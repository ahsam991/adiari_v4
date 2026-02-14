<?php
/**
 * Manager Controller
 * Handles manager dashboard and product management
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../helpers/Session.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../helpers/Security.php';

class ManagerController extends Controller {
    private $productModel;
    private $categoryModel;
    private $orderModel;

    public function __construct() {
        parent::__construct();
        // Ensure user is logged in and is a manager or admin
        if (!Session::isLoggedIn() || !in_array(Session::get('user_role'), ['manager', 'admin'])) {
            $this->redirect('/login');
        }

        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->orderModel = new Order();
    }

    /**
     * Manager Dashboard
     */
    public function dashboard() {
        $stats = [
            'total_products' => $this->productModel->countActiveProducts(),
            'low_stock' => count($this->productModel->getLowStockProducts()),
            'pending_orders' => count($this->orderModel->getPendingOrders()),
        ];

        $this->view('manager/dashboard', [
            'title' => 'Manager Dashboard',
            'stats' => $stats
        ]);
    }

    /**
     * Product List
     */
    public function products() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        $limit = 10;
        $offset = ($page - 1) * $limit;

        if ($search) {
            $products = $this->productModel->searchProducts($search, $limit, $offset);
            $totalProducts = $this->productModel->countSearchProducts($search);
        } else {
            $products = $this->productModel->getActiveProducts($limit, $offset, 'newest'); // Reuse getActive or create getAll for manager
            $totalProducts = $this->productModel->countActiveProducts();
        }

        $totalPages = ceil($totalProducts / $limit);

        $this->view('manager/products/index', [
            'title' => 'Product Management',
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }

    /**
     * Show Create Product Form
     */
    public function createProduct() {
        $categories = $this->categoryModel->getActiveCategories();

        $this->view('manager/products/create', [
            'title' => 'Add New Product',
            'categories' => $categories
        ]);
    }

    /**
     * Store New Product
     */
    public function storeProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/manager/product/create');
        }

        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/product/create');
        }

        $data = [
            'name' => trim($_POST['name']),
            'sku' => trim($_POST['sku']),
            'category_id' => (int)$_POST['category_id'],
            'price' => (float)$_POST['price'],
            'stock_quantity' => (int)$_POST['stock_quantity'],
            'description' => trim($_POST['description']),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_organic' => isset($_POST['is_organic']) ? 1 : 0,
            'is_halal' => isset($_POST['is_halal']) ? 1 : 0,
            'status' => 'active'
        ];

        // Generate slug
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));

        // Validation
        $validator = new Validation();
        $rules = [
            'name' => 'required|min:3',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ];

        if (!$validator->validate($data, $rules)) {
            Session::setFlash('errors', $validator->getErrors());
            Session::setFlash('old', $_POST);
            $this->redirect('/manager/product/create');
        }

        // Handle Image Upload
        if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            $validationResult = Security::validateFileUpload($_FILES['primary_image'], $allowedTypes, $maxSize);
            
            if ($validationResult === true) {
                $filename = Security::generateSecureFilename($_FILES['primary_image']['name']);
                $uploadDir = __DIR__ . '/../../public/uploads/products/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['primary_image']['tmp_name'], $uploadDir . $filename)) {
                    $data['primary_image'] = '/uploads/products/' . $filename;
                } else {
                    Session::setFlash('error', 'Failed to upload image.');
                }
            } else {
                Session::setFlash('error', $validationResult);
                Session::setFlash('old', $_POST);
                $this->redirect('/manager/product/create');
            }
        }

        if ($this->productModel->create($data)) {
            Session::setFlash('success', 'Product created successfully!');
            $this->redirect('/manager/products');
        } else {
            Session::setFlash('error', 'Failed to create product.');
            $this->redirect('/manager/product/create');
        }
    }

    /**
     * Show Edit Product Form
     * @param int $id
     */
    public function editProduct($id) {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            Session::setFlash('error', 'Product not found.');
            $this->redirect('/manager/products');
        }

        $categories = $this->categoryModel->getActiveCategories();

        $this->view('manager/products/edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update Product
     * @param int $id
     */
    public function updateProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/manager/products');
        }

        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect("/manager/product/$id/edit");
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            Session::setFlash('error', 'Product not found.');
            $this->redirect('/manager/products');
        }

        $data = [
            'name' => trim($_POST['name']),
            'sku' => trim($_POST['sku']),
            'category_id' => (int)$_POST['category_id'],
            'price' => (float)$_POST['price'],
            'stock_quantity' => (int)$_POST['stock_quantity'],
            'description' => trim($_POST['description']),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_organic' => isset($_POST['is_organic']) ? 1 : 0,
            'is_halal' => isset($_POST['is_halal']) ? 1 : 0,
        ];
        
        // Update slug if name changes
        if ($data['name'] !== $product['name']) {
             $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name'])));
        }

        // Validation
        $validator = new Validation();
        $rules = [
            'name' => 'required|min:3',
            'sku' => 'required',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ];

        if (!$validator->validate($data, $rules)) {
            Session::setFlash('errors', $validator->getErrors());
            Session::setFlash('old', $_POST);
            $this->redirect("/manager/product/$id/edit");
        }

        // Check SKU uniqueness if changed
        if ($data['sku'] !== $product['sku']) {
             // We need to check if SKU exists in DB (excluding current product)
             // Using raw query via Database class
             $exists = Database::fetchOne("SELECT id FROM products WHERE sku = ? AND id != ?", [$data['sku'], $id]);
             if ($exists) {
                 Session::setFlash('errors', ['sku' => ['SKU already exists.']]);
                 Session::setFlash('old', $_POST);
                 $this->redirect("/manager/product/$id/edit");
             }
        }

        // Handle Image Upload
        if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            $validationResult = Security::validateFileUpload($_FILES['primary_image'], $allowedTypes, $maxSize);
            
            if ($validationResult === true) {
                $filename = Security::generateSecureFilename($_FILES['primary_image']['name']);
                $uploadDir = __DIR__ . '/../../public/uploads/products/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['primary_image']['tmp_name'], $uploadDir . $filename)) {
                    $data['primary_image'] = '/uploads/products/' . $filename;
                    
                    // Optional: Delete old image if exists
                    if ($product['primary_image'] && file_exists(__DIR__ . '/../../public' . $product['primary_image'])) {
                        // unlink(__DIR__ . '/../../public' . $product['primary_image']);
                    }
                } else {
                    Session::setFlash('error', 'Failed to upload image.');
                }
            } else {
                Session::setFlash('error', $validationResult);
                $this->redirect("/manager/product/$id/edit");
            }
        }
        
        // Remove empty primary_image if not updated (to prevent overwriting with null) - although $data only has it if set
        // But if I add it to $data above conditionally, it works.

        if ($this->productModel->update($id, $data)) {
            Session::setFlash('success', 'Product updated successfully!');
            $this->redirect('/manager/products');
        } else {
            Session::setFlash('error', 'Failed to update product.');
            $this->redirect("/manager/product/$id/edit");
        }
    }

    /**
     * Delete Product (Soft Delete)
     * @param int $id
     */
    public function deleteProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->softDelete($id)) {
                Session::setFlash('success', 'Product deleted successfully.');
            } else {
                Session::setFlash('error', 'Failed to delete product.');
            }
        }
        $this->redirect('/manager/products');
    }

    /**
     * Import Products from Excel/CSV
     * Receives JSON data parsed client-side by SheetJS
     */
    public function importProducts() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/manager/products');
        }

        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/products');
        }

        $jsonData = $_POST['import_data'] ?? '';
        $rows = json_decode($jsonData, true);

        if (!$rows || !is_array($rows) || empty($rows)) {
            Session::setFlash('error', 'No valid data found in the uploaded file.');
            $this->redirect('/manager/products');
        }

        // Get all categories for name→ID mapping
        $categories = $this->categoryModel->getActiveCategories();
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[strtolower(trim($cat['name']))] = $cat['id'];
            $categoryMap[strtolower(trim($cat['slug'] ?? ''))] = $cat['id'];
        }

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // +2 because row 1 is header, and index is 0-based

            // Normalize keys to lowercase
            $normalized = [];
            foreach ($row as $key => $value) {
                $normalized[strtolower(trim($key))] = trim((string)$value);
            }

            // Get product name (required)
            $name = $normalized['name'] ?? $normalized['product name'] ?? $normalized['product_name'] ?? '';
            if (empty($name)) {
                $errorCount++;
                $errors[] = "Row {$rowNum}: Missing product name.";
                continue;
            }

            // Get category - try ID first, then name match
            $categoryId = null;
            $catValue = $normalized['category_id'] ?? $normalized['category'] ?? $normalized['cat'] ?? '';
            if (is_numeric($catValue)) {
                $categoryId = (int)$catValue;
            } elseif (!empty($catValue)) {
                $categoryId = $categoryMap[strtolower($catValue)] ?? null;
            }
            if (!$categoryId) {
                // Default to first category if none found
                $categoryId = !empty($categories) ? $categories[0]['id'] : 1;
            }

            // Get price
            $price = $normalized['price'] ?? $normalized['unit price'] ?? $normalized['unit_price'] ?? '0';
            $price = (float)preg_replace('/[^0-9.]/', '', $price);

            // Get stock
            $stock = $normalized['stock'] ?? $normalized['stock_quantity'] ?? $normalized['quantity'] ?? $normalized['qty'] ?? '0';
            $stock = (int)preg_replace('/[^0-9]/', '', $stock);

            // Get SKU - auto-generate if missing
            $sku = $normalized['sku'] ?? $normalized['barcode'] ?? '';
            if (empty($sku)) {
                $sku = 'IMP-' . strtoupper(substr(md5($name . time() . $index), 0, 8));
            }

            // Check if SKU already exists
            $existingSku = Database::fetchOne("SELECT id FROM products WHERE sku = ?", [$sku], 'grocery');
            if ($existingSku) {
                $sku = $sku . '-' . rand(100, 999);
            }

            // Get description
            $description = $normalized['description'] ?? $normalized['desc'] ?? '';

            // Get sale price
            $salePrice = $normalized['sale_price'] ?? $normalized['sale price'] ?? $normalized['discount_price'] ?? '';
            $salePrice = !empty($salePrice) ? (float)preg_replace('/[^0-9.]/', '', $salePrice) : null;

            // Get unit
            $unit = $normalized['unit'] ?? $normalized['uom'] ?? '';

            // Boolean flags
            $isFeatured = in_array(strtolower($normalized['is_featured'] ?? $normalized['featured'] ?? ''), ['1', 'yes', 'true']) ? 1 : 0;
            $isOrganic = in_array(strtolower($normalized['is_organic'] ?? $normalized['organic'] ?? ''), ['1', 'yes', 'true']) ? 1 : 0;
            $isHalal = in_array(strtolower($normalized['is_halal'] ?? $normalized['halal'] ?? ''), ['1', 'yes', 'true']) ? 1 : 0;

            // Build product data
            $productData = [
                'name' => $name,
                'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
                'sku' => $sku,
                'category_id' => $categoryId,
                'price' => $price,
                'stock_quantity' => $stock,
                'description' => $description,
                'is_featured' => $isFeatured,
                'is_organic' => $isOrganic,
                'is_halal' => $isHalal,
                'status' => 'active'
            ];

            if ($salePrice !== null && $salePrice > 0) {
                $productData['sale_price'] = $salePrice;
            }
            if (!empty($unit)) {
                $productData['unit'] = $unit;
            }

            try {
                if ($this->productModel->create($productData)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = "Row {$rowNum}: Failed to insert '{$name}'.";
                }
            } catch (Exception $e) {
                $errorCount++;
                $errors[] = "Row {$rowNum}: Error - " . $e->getMessage();
            }
        }

        if ($successCount > 0) {
            $msg = "{$successCount} product(s) imported successfully!";
            if ($errorCount > 0) {
                $msg .= " ({$errorCount} failed)";
            }
            Session::setFlash('success', $msg);
        }
        if ($errorCount > 0 && $successCount === 0) {
            Session::setFlash('error', "Import failed. " . implode(' | ', array_slice($errors, 0, 5)));
        } elseif (!empty($errors)) {
            Session::setFlash('error', implode(' | ', array_slice($errors, 0, 5)));
        }

        $this->redirect('/manager/products');
    }

    /**
     * Category list
     */
    public function categories() {
        $categories = $this->categoryModel->getCategoriesWithProductCount();
        $this->view('manager/categories/index', [
            'title' => 'Category Management',
            'categories' => $categories
        ]);
    }

    public function createCategory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrfToken($this->post('csrf_token'))) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/categories');
        }
        $name = trim($this->post('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $description = trim($this->post('description'));
        if (strlen($name) < 2) {
            Session::setFlash('error', 'Category name is required.');
            $this->redirect('/manager/categories');
        }
        $this->categoryModel->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'status' => 'active'
        ]);
        Session::setFlash('success', 'Category created.');
        $this->redirect('/manager/categories');
    }

    public function updateCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrfToken($this->post('csrf_token'))) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/categories');
        }
        $cat = $this->categoryModel->find($id);
        if (!$cat) {
            Session::setFlash('error', 'Category not found.');
            $this->redirect('/manager/categories');
        }
        $name = trim($this->post('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $description = trim($this->post('description'));
        $status = $this->post('status') ?: 'active';
        $this->categoryModel->update($id, ['name' => $name, 'slug' => $slug, 'description' => $description, 'status' => $status]);
        Session::setFlash('success', 'Category updated.');
        $this->redirect('/manager/categories');
    }

    /**
     * Order list
     */
    public function orders() {
        $status = isset($_GET['status']) ? trim($_GET['status']) : null;
        $orders = $status
            ? $this->orderModel->getOrdersByStatus($status)
            : $this->orderModel->getRecentOrders(100);
        $this->view('manager/orders/index', [
            'title' => 'Order Management',
            'orders' => $orders,
            'filterStatus' => $status
        ]);
    }

    public function orderDetail($id) {
        $order = $this->orderModel->getOrderWithItems($id);
        if (!$order) {
            Session::setFlash('error', 'Order not found.');
            $this->redirect('/manager/orders');
        }
        $this->view('manager/orders/show', [
            'title' => 'Order ' . $order['order_number'],
            'order' => $order
        ]);
    }

    public function updateOrderStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrfToken($this->post('csrf_token'))) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/orders');
        }
        $order = $this->orderModel->find($id);
        if (!$order) {
            Session::setFlash('error', 'Order not found.');
            $this->redirect('/manager/orders');
        }
        $status = trim($this->post('status'));
        $allowed = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $allowed)) {
            Session::setFlash('error', 'Invalid status.');
            $this->redirect('/manager/order/' . $id);
        }
        $this->orderModel->updateOrderStatus($id, $status);
        Session::setFlash('success', 'Order status updated.');
        $this->redirect('/manager/order/' . $id);
    }

    /**
     * Inventory: list products with stock, allow quick update
     */
    public function inventory() {
        $lowStock = $this->productModel->getLowStockProducts();
        $products = $this->productModel->findAll([], 100, 0); // Get products for inventory list - Model has findAll(conditions, limit, offset)
        $this->view('manager/inventory/index', [
            'title' => 'Inventory',
            'products' => $products,
            'lowStock' => $lowStock
        ]);
    }

    public function updateInventory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrfToken($this->post('csrf_token'))) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/manager/inventory');
        }
        $productId = (int) $this->post('product_id');
        $quantity = (int) $this->post('quantity');
        if ($productId < 1) {
            Session::setFlash('error', 'Invalid product.');
            $this->redirect('/manager/inventory');
        }
        $product = $this->productModel->find($productId);
        if (!$product) {
            Session::setFlash('error', 'Product not found.');
            $this->redirect('/manager/inventory');
        }
        $this->productModel->update($productId, ['stock_quantity' => max(0, $quantity)]);
        Session::setFlash('success', 'Stock updated.');
        $this->redirect('/manager/inventory');
    }
}
