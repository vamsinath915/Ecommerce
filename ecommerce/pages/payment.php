<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
require '../vendor/autoload.php'; // from composer

use Razorpay\Api\Api;

$keyId = "YOUR_KEY_ID";
$keySecret = "YOUR_KEY_SECRET";

$user_id = $_SESSION['user_id'];

// Fetch cart total
$stmt = $conn->prepare("SELECT SUM(p.price * c.quantity) as total FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$totalData = $stmt->fetch(PDO::FETCH_ASSOC);
$total = $totalData['total'] * 100; // Razorpay expects amount in paise

$api = new Api($keyId, $keySecret);

// Create order
$orderData = [
    'receipt'         => 'order_rcptid_' . time(),
    'amount'          => $total, // amount in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);
$order_id = $razorpayOrder['id'];

// Store in session to verify after payment
$_SESSION['razorpay_order_id'] = $order_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <h2>Pay with Razorpay</h2>
    <form action="payment_success.php" method="POST">
        <script
            src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="<?= $keyId; ?>"
            data-amount="<?= $total; ?>"
            data-currency="INR"
            data-order_id="<?= $order_id; ?>"
            data-buttontext="Pay Now"
            data-name="My Online Store"
            data-description="Test Transaction"
            data-image="../images/cart-icon.png"
            data-prefill.name="Test User"
            data-prefill.email="test@example.com"
            data-theme.color="#3399cc">
        </script>
        <input type="hidden" name="hidden">
    </form>
</body>
</html>
