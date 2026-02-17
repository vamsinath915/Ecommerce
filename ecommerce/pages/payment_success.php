<?php
session_start();
include '../includes/db.php';
require '../vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = "YOUR_KEY_ID";
$keySecret = "YOUR_KEY_SECRET";

$api = new Api($keyId, $keySecret);

if (!empty($_POST['razorpay_payment_id'])) {
    try {
        $payment = $api->payment->fetch($_POST['razorpay_payment_id']);

        if ($payment->status == 'captured') {
            $user_id = $_SESSION['user_id'];

            // Move cart to orders table
            $stmt = $conn->prepare("SELECT c.*, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
            $stmt->execute([$user_id]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->execute([$user_id, $total]);
            $orderId = $conn->lastInsertId();

            // Insert order items
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
            }

            // Clear cart
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$user_id]);

            echo "<h2>✅ Payment Successful!</h2>";
            echo "<p>Payment ID: " . $_POST['razorpay_payment_id'] . "</p>";
            echo "<a href='../index.php'>Back to Shop</a>";
        }
    } catch (Exception $e) {
        echo "❌ Payment failed: " . $e->getMessage();
    }
}
?>
