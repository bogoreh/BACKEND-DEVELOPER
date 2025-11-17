<?php
include 'includes/header.php';
include 'includes/functions.php';

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;
        
        switch ($_POST['action']) {
            case 'add':
                addToCart($productId, $quantity);
                break;
            case 'update':
                if (isset($_SESSION['cart'][$productId])) {
                    if ($quantity <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    } else {
                        $_SESSION['cart'][$productId] = $quantity;
                    }
                }
                break;
            case 'remove':
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                }
                break;
        }
    }
    header('Location: cart.php');
    exit;
}

$cartItems = getCartItems();
$cartTotal = getCartTotal();
?>

<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>
    
    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p>Start shopping to add items to your cart</p>
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="<?php echo $item['image']; ?>" class="img-fluid rounded" alt="<?php echo $item['name']; ?>">
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo $item['name']; ?></h5>
                            <p class="text-muted">$<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                        <div class="col-md-3">
                            <form method="POST" class="d-flex align-items-center">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="update">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="width: 80px;">
                                <button type="submit" class="btn btn-outline-primary btn-sm ms-2">Update</button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <strong>$<?php echo number_format($item['total'], 2); ?></strong>
                        </div>
                        <div class="col-md-1">
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($cartTotal, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>$<?php echo $cartTotal > 50 ? '0.00' : '5.99'; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax:</span>
                            <span>$<?php echo number_format($cartTotal * 0.08, 2); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>$<?php 
                                $shipping = $cartTotal > 50 ? 0 : 5.99;
                                $tax = $cartTotal * 0.08;
                                echo number_format($cartTotal + $shipping + $tax, 2); 
                            ?></strong>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="products.php" class="btn btn-outline-primary">Continue Shopping</a>
                            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>