<?php
include 'db.php';
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) { echo "<script>alert('Registration Successful! Please Login.');</script>"; }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else { echo "<script>alert('Invalid Credentials!');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>SOC Portal - Login</title>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #161b22; padding: 40px; border-radius: 8px; border: 1px solid #30363d; box-shadow: 0 4px 12px rgba(0,0,0,0.5); width: 350px; text-align: center; }
        h2 { color: #58a6ff; margin-bottom: 5px; font-size: 22px; }
        h4 { color: #8b949e; margin-top: 0; margin-bottom: 30px; font-weight: 400; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin: 10px 0; border-radius: 6px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box; }
        input:focus { border-color: #58a6ff; outline: none; }
        .btn-group { display: flex; gap: 10px; margin-top: 15px; }
        button { flex: 1; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 14px; }
        .btn-login { background-color: #238636; color: white; }
        .btn-login:hover { background-color: #2ea44f; }
        .btn-reg { background-color: #21262d; color: #c9d1d9; border: 1px solid #30363d; }
        .btn-reg:hover { background-color: #30363d; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>GROUP 5 - SOC PORTAL</h2>
        <h4>Incident Reporting System</h4>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="btn-group">
                <button type="submit" name="login" class="btn-login">Login</button>
                <button type="submit" name="register" class="btn-reg">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
