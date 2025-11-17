<?php
include 'includes/header.php';
include 'includes/functions.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to ShopEasy</h1>
        <p class="lead">Discover amazing products at great prices</p>
        <a href="products.php" class="btn btn-light btn-lg mt-3">Shop Now</a>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h4>Free Shipping</h4>
                <p>Free shipping on all orders over $50</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <h4>Easy Returns</h4>
                <p>30-day money back guarantee</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h4>Secure Payment</h4>
                <p>Your payment information is safe with us</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row">
            <?php
            $products = getProducts();
            $featuredProducts = array_slice($products, 0, 3); // Show first 3 as featured
            foreach ($featuredProducts as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top product-image" alt="<?php echo $product['name']; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text flex-grow-1"><?php echo $product['description']; ?></p>
                        <div class="mt-auto">
                            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-outline-primary">View All Products</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>