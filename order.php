<?php
include 'config.php';

$orderPlaced = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['customer_name']);
    $product = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    $sql = "INSERT INTO orders (customer_name, product_id, quantity) VALUES ('$name', $product, $quantity)";
    if ($conn->query($sql) === TRUE) {
        $orderPlaced = true;
        // Fetch product info for receipt
        $productInfo = $conn->query("SELECT * FROM products WHERE id = $product")->fetch_assoc();
    } else {
        $errorMsg = $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Place Order | Our Catering Service</title>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            background: linear-gradient(to right, #a8e6cf, #dcedc1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 100, 0, 0.1);
            color: #2e7d32;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #2e7d32;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            color: #2e7d32;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border: 1.8px solid #a5d6a7;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s ease;
            color: #2e7d32;
            background-color: white;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #4caf50;
            outline: none;
        }
        button {
            margin-top: 30px;
            width: 100%;
            background-color: #4caf50;
            color: white;
            font-size: 1.1em;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #357a38;
        }
        a.back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
        #receipt {
            display: none;
            margin-top: 30px;
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            color: #2e7d32;
        }
        #receipt h2 {
            text-align: center;
            color: #2e7d32;
        }
    </style>
</head>
<body>

    <h1>Place Your Order</h1>

    <form method="POST" id="orderForm">
        <label for="customer_name">Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="product_id">Product:</label>
        <select id="product_id" name="product_id" required>
            <?php
            $result = $conn->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . " (₱" . number_format($row['price'], 2) . ")</option>";
            }
            ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1" required>

        <button type="submit">Submit Order</button>
    </form>

   

    <!-- Receipt Section -->
    <?php if ($orderPlaced): ?>
    <div id="receipt">
        <h2>Order Receipt</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Product:</strong> <?php echo htmlspecialchars($productInfo['name']); ?></p>
        <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
        <p><strong>Total Price:</strong> ₱<?php echo number_format($productInfo['price'] * $quantity, 2); ?></p>
        <a href="index.php" class="back-link">&larr; Back to Home</a>
    </div>
    <?php endif; ?>

    <?php if ($orderPlaced): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Order Placed!',
                text: 'Thank you for your order. Here is your receipt below.',
                confirmButtonText: 'View Receipt'
            }).then(() => {
                document.getElementById('receipt').style.display = 'block';
                document.getElementById('orderForm').style.display = 'none';
            });
        });
    </script>
    <?php elseif (isset($errorMsg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo addslashes($errorMsg); ?>',
                confirmButtonText: 'OK'
            });
        });
    </script>
    <?php endif; ?>

</body>
</html>
