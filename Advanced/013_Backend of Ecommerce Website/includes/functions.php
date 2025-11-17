<?php
// Simple utility functions
function getProducts() {
    global $conn;
    $products = [];
    
    // In a real app, this would come from database
    // For demo, we'll use static data
    $products = [
        [
            'id' => 1,
            'name' => 'Wireless Headphones',
            'price' => 99.99,
            'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop',
            'description' => 'High-quality wireless headphones with noise cancellation'
        ],
        [
            'id' => 2,
            'name' => 'Smart Watch',
            'price' => 199.99,
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop',
            'description' => 'Feature-rich smartwatch with health monitoring'
        ],
        [
            'id' => 3,
            'name' => 'Laptop Backpack',
            'price' => 49.99,
            'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
            'description' => 'Durable laptop backpack with multiple compartments'
        ],
        [
            'id' => 4,
            'name' => 'Bluetooth Speaker',
            'price' => 79.99,
            'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&h=500&fit=crop',
            'description' => 'Portable Bluetooth speaker with excellent sound quality'
        ]
    ];
    
    return $products;
}

function getProductById($id) {
    $products = getProducts();
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

function addToCart($productId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

function getCartItems() {
    $cartItems = [];
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = getProductById($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['total'] = $product['price'] * $quantity;
                $cartItems[] = $product;
            }
        }
    }
    return $cartItems;
}

function getCartTotal() {
    $total = 0;
    $cartItems = getCartItems();
    foreach ($cartItems as $item) {
        $total += $item['total'];
    }
    return $total;
}
?>