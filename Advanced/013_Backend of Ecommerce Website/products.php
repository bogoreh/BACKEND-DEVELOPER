<?php
include 'includes/header.php';
include 'includes/functions.php';
?>

<div class="container py-5">
    <h1 class="text-center mb-5">Our Products</h1>
    
    <div class="row">
        <?php
        $products = getProducts();
        foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100">
                <img src="<?php echo $product['image']; ?>" class="card-img-top product-image" alt="<?php echo $product['name']; ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text flex-grow-1"><?php echo $product['description']; ?></p>
                    <div class="mt-auto">
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <div class="d-grid gap-2">
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">View Details</a>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>