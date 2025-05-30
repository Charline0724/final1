<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel | All Orders</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            background-color: #f9fdf9; /* very light greenish white */
            color: #2e7d32; /* medium green */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.1); /* subtle green shadow */
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #2e7d32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(46, 125, 50, 0.1);
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        thead {
            background-color: #4caf50; /* bright green */
            color: white;
        }
        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid #d0e8d0; /* light green border */
            font-size: 1em;
        }
        tbody tr:hover {
            background-color: #e8f5e9; /* very light green on hover */
        }
        a.back-link {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #4caf50;
            font-weight: 600;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }
        a.back-link:hover {
            color: #2e7d32;
            text-decoration: underline;
        }
        .delete-btn {
            cursor: pointer;
            color: #c62828; /* dark red */
            font-size: 1.3em;
            transition: color 0.3s ease;
            border: none;
            background: none;
        }
        .delete-btn:hover {
            color: #e53935; /* bright red */
        }
        form.delete-form {
            margin: 0;
        }
    </style>
</head>
<body>

<h1>All Orders</h1>

<table>
    <thead>
        <tr>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Handle delete request
    if (isset($_POST['delete_order_id'])) {
        $deleteId = (int)$_POST['delete_order_id'];
        $conn->query("DELETE FROM orders WHERE id = $deleteId");
        // Redirect to avoid resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $query = "SELECT orders.id, orders.customer_name, products.name AS product, orders.quantity 
              FROM orders 
              JOIN products ON orders.product_id = products.id";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['customer_name']) . "</td>
                <td>" . htmlspecialchars($row['product']) . "</td>
                <td>" . (int)$row['quantity'] . "</td>
                <td>
                    <form method='POST' class='delete-form' onsubmit='return confirm(\"Are you sure you want to delete this order?\");'>
                        <input type='hidden' name='delete_order_id' value='" . (int)$row['id'] . "'>
                        <button type='submit' class='delete-btn' title='Delete order'>&#128465;</button>
                    </form>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>

<a href="index.php" class="back-link">&larr; Back to Home</a>

</body>
</html>
