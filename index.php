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
<html>
<head><title>Cyber Security Incident Portal</title></head>
<body>
    <h2>Group 5: Cyber Security Incident Reporting System</h2>
    <h3>Register / Login</h3>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="register">Register</button>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
