<?php
/**
 * Checkout Controller
 * Handles checkout flow: show form, process order
 */

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../helpers/Session.php';
require_once __DIR__ . '/../helpers/Security.php';
require_once __DIR__ . '/../helpers/Logger.php';

class CheckoutController extends Controller {
    private $cartModel;
    private $orderModel;
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    private function requireUser() {
        if (!Session::isLoggedIn()) {
            Session::setFlash('error', 'Please login to checkout.');
            $this->redirect('/login');
        }
        return (int) Session::get('user_id');
    }

    /**
     * Checkout page: cart summary + shipping form
     */
    public function index() {
        $userId = $this->requireUser();

        // Prevent admin/manager from purchasing
        if (in_array(Session::get('user_role'), ['admin', 'manager'])) {
            Session::setFlash('error', 'Admins and Managers cannot place orders.');
            $this->redirect('/cart');
        }
        $items = $this->cartModel->getUserCart($userId);
        $totals = $this->cartModel->getCartTotals($userId);
        $validation = $this->cartModel->validateCart($userId);

        if (empty($items)) {
            Session::setFlash('error', 'Your cart is empty.');
            $this->redirect('/cart');
        }

        if (!$validation['valid']) {
            Session::setFlash('error', implode(' ', $validation['errors']));
            $this->redirect('/cart');
        }

        // Pre-fill from session user if available
        $user = Session::get('user_email') ? [
            'first_name' => Session::get('user_name') ? explode(' ', Session::get('user_name'))[0] : '',
            'last_name' => Session::get('user_name') ? (explode(' ', Session::get('user_name'))[1] ?? '') : '',
            'email' => Session::get('user_email'),
        ] : [];

        $this->view('checkout/index', [
            'title' => 'Checkout - ADI ARI Fresh',
            'items' => $items,
            'totals' => $totals,
            'user' => $user
        ]);
    }

    /**
     * Process checkout: create order, clear cart
     */
    public function process() {
        $userId = $this->requireUser();

        // Prevent admin/manager from purchasing
        if (in_array(Session::get('user_role'), ['admin', 'manager'])) {
            Session::setFlash('error', 'Admins and Managers cannot place orders.');
            $this->redirect('/cart');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/checkout');
        }

        if (!Security::validateCsrfToken($this->post('csrf_token'))) {
            Session::setFlash('error', 'Invalid request.');
            $this->redirect('/checkout');
        }

        $items = $this->cartModel->getUserCart($userId);
        $totals = $this->cartModel->getCartTotals($userId);
        $validation = $this->cartModel->validateCart($userId);

        if (empty($items)) {
            Session::setFlash('error', 'Your cart is empty.');
            $this->redirect('/cart');
        }

        if (!$validation['valid']) {
            Session::setFlash('error', implode(' ', $validation['errors']));
            $this->redirect('/cart');
        }

        $first = trim($this->post('shipping_first_name'));
        $last = trim($this->post('shipping_last_name'));
        $email = trim($this->post('shipping_email'));
        $phone = trim($this->post('shipping_phone'));
        $address1 = trim($this->post('shipping_address_line1'));
        $address2 = trim($this->post('shipping_address_line2'));
        $city = trim($this->post('shipping_city'));
        $state = trim($this->post('shipping_state'));
        $postal = trim($this->post('shipping_postal_code'));
        $country = trim($this->post('shipping_country')) ?: 'Japan';
        $notes = trim($this->post('customer_notes'));

        if (!$first || !$last || !$email || !$phone || !$address1 || !$city) {
            Session::setFlash('error', 'Please fill in all required shipping fields.');
            Session::setFlash('old', $_POST);
            $this->redirect('/checkout');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('error', 'Please enter a valid email address.');
            Session::setFlash('old', $_POST);
            $this->redirect('/checkout');
        }

        $subtotal = $totals['subtotal'];
        $discountAmount = 0;
        $taxAmount = 0;
        $shippingCost = 0;
        $totalAmount = $subtotal + $taxAmount + $shippingCost - $discountAmount;

        $orderData = [
            'user_id' => $userId,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'coupon_code' => null,
            'payment_method' => $this->post('payment_method') ?: 'cod',
            'payment_status' => 'pending',
            'shipping_first_name' => $first,
            'shipping_last_name' => $last,
            'shipping_email' => $email,
            'shipping_phone' => $phone,
            'shipping_address_line1' => $address1,
            'shipping_address_line2' => $address2,
            'shipping_city' => $city,
            'shipping_state' => $state,
            'shipping_postal_code' => $postal,
            'shipping_country' => $country,
            'status' => 'pending',
            'customer_notes' => $notes,
            'admin_notes' => null
        ];

        $orderItems = [];
        foreach ($items as $row) {
            $qty = (int) $row['quantity'];
            $price = (float) $row['price'];
            $orderItems[] = [
                'product_id' => $row['product_id'],
                'product_name' => $row['name'],
                'product_sku' => $row['sku'] ?? null,
                'quantity' => $qty,
                'unit_price' => $price,
                'total_price' => $qty * $price
            ];
        }

        try {
            $orderId = $this->orderModel->createOrder($orderData, $orderItems);

            // Decrease stock
            foreach ($orderItems as $item) {
                $this->productModel->updateStock($item['product_id'], -$item['quantity']);
            }

            $this->cartModel->clearCart($userId);

            // Log order placement activity
            Logger::activity($userId, 'order_placed', [
                'order_id' => $orderId,
                'total_amount' => $orderData['total_amount'],
                'payment_method' => $orderData['payment_method'],
                'items_count' => count($orderItems)
            ]);

            Session::setFlash('success', 'Order placed successfully!');
            $this->redirect('/order/' . $orderId);
        } catch (Exception $e) {
            Session::setFlash('error', 'Unable to place order. Please try again.');
            $this->redirect('/checkout');
        }
    }
}
