# Phase 4 Testing Guide: Product Management

## Instructions
1. Login as Manager (`manager@adiari.com` / `manager123`) or register a new manager account via database seeding if default accounts are not yet created. (Note: `manager123` is the hash for the default seeder password)
2. Use the provided routes to test product browsing and management features.

## Test Cases

### 1. Manager Dashboard & Navigation
- **Check Dashboard:**
  - Login as Manager.
  - Navigate to `/manager`.
  - Verify "Total Products" count matches database records.
  - Verify "Low Stock Items" count is accurate.
  - Click "Products" in sidebar and ensure it navigates to `/manager/products`.

### 2. Product Management (CRUD)
- **Create Product:**
  - Navigate to `/manager/product/create`.
  - Fill out the form with valid data:
    - Name: "Test Apple"
    - SKU: "APPLE-TEST"
    - Category: Select valid category.
    - Price: 1.99
    - Stock: 100
    - Featured: Checked
  - Upload a valid image (JPG/PNG < 5MB).
  - Submit the form.
  - Verify success message and redirection to product list.
  - Verify the product appears in the list.

- **Edit Product:**
  - Click "Edit" on "Test Apple".
  - Change Price to 2.49.
  - Uncheck "Featured".
  - Submit the form.
  - Verify success message.
  - Verify changes are reflected in the list (Price: 2.49).

- **Upload New Image:**
  - Edit "Test Apple" again.
  - Upload a new image.
  - Submit.
  - Verify the new image is displayed on the product page.

- **Delete Product:**
  - Find "Test Apple" in the list.
  - Click "Delete".
  - Confirm the alert.
  - Verify success message.
  - Verify the product is removed from the list.

- **Validation:**
  - Attempt to create a product without a name/sku.
  - Verify error messages appear.
  - Attempt to upload a non-image file (e.g., .txt).
  - Verify error message.

### 3. Public Product Browsing
- **Product List (Homepage/Shop):**
  - Navigate to `/products`.
  - Verify products are displayed in grid view.
  - Check pagination links at the bottom.
  - Use the "Sort by" dropdown (e.g., Price: Low to High) and verify order changes.

- **Product Search:**
  - Enter "Apple" in the sidebar search box.
  - Verify search results show "Apple" related products.
  - Verify "No Products Found" message for non-existent terms (e.g., "SpaceShip").

- **Category Filter:**
  - Click on a category in the sidebar (e.g., "Fruits").
  - Verify the page displays only products from that category.
  - Verify the breadcrumb shows `Home / Shop / Fruits`.

- **Product Detail:**
  - Click on a product card.
  - Verify redirection to `/product/{id}`.
  - Verify product image, price, stock, and description are correct.
  - Check "Related Products" section at the bottom.
  - Test quantity selector (+/- buttons).
  - Click "Add to Cart" (should submit form, currently route might redirect or json response depending on CartController status, but form action is `/cart/add`).

### 4. Edge Cases
- **Low Stock Display:**
  - create a product with stock = 0.
  - Verify it shows "Out of Stock" on product detail page.
  - Verify "Add to Cart" button is disabled.

- **File Upload Limits:**
  - Attempt to upload an image > 5MB.
  - Verify error message.

## Common Issues
- **Missing Upload Directory:** Ensure `public/uploads/products/` exists and has write permissions.
- **Route Errors:** Check `routes/web.php` for correct controller mapping.
- **Database Drift:** Ensure `products` table has `slug`, `primary_image`, `is_featured`, etc. columns.
