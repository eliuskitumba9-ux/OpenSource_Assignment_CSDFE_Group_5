<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username'])) { header("Location: index.php"); exit(); }

if (isset($_POST['report'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $severity = $_POST['severity'];
    $user = $_SESSION['username'];
    
    $stmt = $conn->prepare("INSERT INTO incidents (title, description, severity, reported_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $desc, $severity, $user);
    $stmt->execute();
    echo "<script>alert('Incident Reported Successfully!');</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></h2>
    <h3>Report a New Security Incident</h3>
    <form method="POST">
        <input type="text" name="title" placeholder="Incident Title (e.g., Phishing Attack)" required><br><br>
        <textarea name="description" placeholder="Describe the incident..." required></textarea><br><br>
        <select name="severity">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
            <option value="Critical">Critical</option>
        </select><br><br>
        <button type="submit" name="report">Submit Incident Report</button>
    </form>
    <br>
    <a href="view_incidents.php">View Reported Incidents & Search</a>
</body>
</html>
