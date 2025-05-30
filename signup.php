<?php
include 'config.php';
session_start();
$signupSuccess = false;
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        $signupSuccess = true;
    } else {
        $errorMsg = $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | Food Catering System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #a8e6cf, #dcedc1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .signup-box {
            background-color: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 100, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 30px;
            color: #2e7d32;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #2e7d32;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1.5px solid #a5d6a7;
            border-radius: 6px;
            font-size: 1em;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            margin-top: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357a38;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            text-decoration: none;
            color: #4caf50;
        }
    </style>
</head>
<body>

<div class="signup-box">
    <h2>Create an Account</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Select Role:</label>
        <select name="role" id="role" required>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Sign Up</button>
    </form>
    <div class="link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

<?php if ($signupSuccess): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Signup Successful!',
        text: 'You can now log in to your account.',
        confirmButtonText: 'Login',
    }).then(() => {
        window.location.href = 'login.php';
    });
</script>
<?php elseif (!empty($errorMsg)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Signup Failed',
        text: '<?= addslashes($errorMsg) ?>',
        confirmButtonText: 'OK',
    });
</script>
<?php endif; ?>

</body>
</html>
