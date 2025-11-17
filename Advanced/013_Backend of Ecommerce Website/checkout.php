<?php
include 'includes/header.php';
include 'includes/functions.php';

$cartItems = getCartItems();
$cartTotal = getCartTotal();

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}
?>

<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Shipping Information</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="zip" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Payment Information</h5>
                    <form>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry" placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cvv" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <?php foreach ($cartItems as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo $item['name']; ?> (x<?php echo $item['quantity']; ?>)</span>
                        <span>$<?php echo number_format($item['total'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                    
                    <hr>
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
                    
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" onclick="processOrder()">
                            <i class="fas fa-lock"></i> Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function processOrder() {
    alert('Thank you for your order! This is a demo store, so no actual order was placed.');
    window.location.href = 'index.php';
}
</script>

<?php include 'includes/footer.php'; ?>