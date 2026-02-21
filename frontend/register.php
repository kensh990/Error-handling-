<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? "";

unset($_SESSION['errors']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .container {
            width: 350px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input { width:100%; padding:10px; margin:8px 0; }
        button {
            width:100%;
            padding:10px;
            background:#007BFF;
            color:white;
            border:none;
            cursor:pointer;
        }
        .error { color:red; font-size:14px; }
        .success { color:green; font-size:14px; }
    </style>

    <script>
        function validateForm() {
            let username = document.forms["regForm"]["username"].value.trim();
            let password = document.forms["regForm"]["password"].value.trim();

            let pattern = /^[a-zA-Z0-9_]{4,20}$/;

            if (!pattern.test(username)) {
                alert("Invalid username format.");
                return false;
            }

            if (password.length < 6) {
                alert("Password must be at least 6 characters.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <?php foreach ($errors as $error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form name="regForm" method="POST" action="../backend/register_process.php" onsubmit="return validateForm()">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
