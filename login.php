<?php
session_start();
include 'config.php';

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $loginError = "Incorrect password.";
        }
    } else {
        $loginError = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Food Catering System</title>
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

        .login-box {
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

        input {
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

<div class="login-box">
    <h2>Login to Your Account</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
    <div class="link">
        Don't have an account? <a href="signup.php">Sign up here</a>
    </div>
</div>

<?php if (!empty($loginError)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: '<?= addslashes($loginError) ?>',
        confirmButtonText: 'Try Again'
    });
</script>
<?php endif; ?>

</body>
</html>
