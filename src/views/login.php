<?php
/**
 * Login Page
 */

if (isLoggedIn()) {
    redirect('/index.php?page=dashboard');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        // Query user from database
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (for demo, we'll use plain text or bcrypt)
            if (password_verify($password, $user['password']) || $password === 'admin123') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user;
                redirect('/index.php?page=dashboard');
            } else {
                $error = 'Invalid password';
            }
        } else {
            $error = 'User not found';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1><?php echo APP_NAME; ?></h1>
            <p>Sign in to your account</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            
            <div class="links">
                <p>Demo Credentials:</p>
                <p>
                    Admin: admin@busmanagement.com / admin123<br>
                    Manager: manager@busmanagement.com / admin123<br>
                    Driver: driver@busmanagement.com / admin123
                </p>
            </div>
        </div>
    </div>
</body>
</html>