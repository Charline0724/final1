<?php
include 'config.php';

$bookingPlaced = false;
$errorMsg = "";
$serviceInfo = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['customer_name']);
    $service = (int)$_POST['service_id'];
    $date = $conn->real_escape_string($_POST['event_date']);
    $people = (int)$_POST['num_people'];

    $sql = "INSERT INTO bookings (customer_name, service_id, event_date, num_people) 
            VALUES ('$name', $service, '$date', $people)";


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Book Now | Our Catering Service</title>
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
        input[type="date"],
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
        input:focus, select:focus {
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

    <h1>Book a Catering Service</h1>

    <form method="POST" id="bookingForm">
        <label for="customer_name">Full Name:</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="service_id">Select Service:</label>
        <select id="service_id" name="service_id" required>
            <option value="" disabled selected>Select a service</option>
            <?php
            $result = $conn->query("SELECT * FROM services");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . " (₱" . number_format($row['price'], 2) . ")</option>";
            }
            ?>
        </select>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <label for="num_people">Number of People:</label>
        <input type="number" id="num_people" name="num_people" min="1" value="1" required>

        <button type="submit">Book Now</button>
    </form>

    <?php if ($bookingPlaced): ?>
    <div id="receipt">
        <h2>Booking Receipt</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Service:</strong> <?php echo htmlspecialchars($serviceInfo['name']); ?></p>
        <p><strong>Event Date:</strong> <?php echo htmlspecialchars($date); ?></p>
        <p><strong>Guests:</strong> <?php echo $people; ?></p>
        <p><strong>Total Price:</strong> ₱<?php echo number_format($serviceInfo['price'] * $people, 2); ?></p>
        <a href="index.php" class="back-link">&larr; Back to Home</a>
    </div>
    <?php endif; ?>

    <?php if ($bookingPlaced): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Booking Successful!',
                text: 'Thank you for your booking. Receipt is shown below.',
                confirmButtonText: 'View Receipt'
            }).then(() => {
                document.getElementById('receipt').style.display = 'block';
                document.getElementById('bookingForm').style.display = 'none';
            });
        });
    </script>
    <?php elseif (!empty($errorMsg)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Booking Failed!',
                text: '<?php echo addslashes($errorMsg); ?>',
                confirmButtonText: 'Try Again'
            });
        });
    </script>
    <?php endif; ?>

</body>
</html>
