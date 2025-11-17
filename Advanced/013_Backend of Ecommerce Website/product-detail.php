<?php
include 'includes/header.php';
include 'includes/functions.php';

if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$productId = $_GET['id'];
$product = getProductById($productId);

if (!$product) {
    header('Location: products.php');
    exit;
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $product['image']; ?>" class="img-fluid rounded" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo $product['name']; ?></h1>
            <p class="lead"><?php echo $product['description']; ?></p>
            <h2 class="price">$<?php echo number_format($product['price'], 2); ?></h2>
            
            <div class="mt-4">
                <form method="POST" action="cart.php" class="d-flex gap-3 align-items-center">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="quantity-controls">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px;">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
            
            <div class="mt-4">
                <h5>Product Features:</h5>
                <ul>
                    <li>High-quality materials</li>
                    <li>30-day money back guarantee</li>
                    <li>Free shipping on orders over $50</li>
                    <li>24/7 customer support</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>