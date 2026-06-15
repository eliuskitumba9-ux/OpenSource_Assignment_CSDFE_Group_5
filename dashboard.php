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
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>SOC - Dashboard</title>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #161b22; border: 1px solid #30363d; border-radius: 6px; }
        .navbar h3 { margin: 0; color: #58a6ff; }
        .logout-link { color: #f85149; text-decoration: none; font-weight: bold; }
        .container { max-width: 600px; margin: 40px auto; background-color: #161b22; padding: 30px; border-radius: 8px; border: 1px solid #30363d; }
        h2 { text-align: center; color: #c9d1d9; margin-top: 0; }
        input[type="text"], textarea, select { width: 100%; padding: 12px; margin: 12px 0; border-radius: 6px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; box-sizing: border-box; }
        textarea { height: 120px; resize: none; }
        button { width: 100%; padding: 14px; background-color: #238636; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        button:hover { background-color: #2ea44f; }
        .view-btn { display: block; text-align: center; margin-top: 20px; color: #58a6ff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="navbar">
        <h3>Cyber Incident Dashboard</h3>
        <span>Operator: <strong><?php echo $_SESSION['username']; ?></strong> | <a href="logout.php" class="logout-link">Logout</a></span>
    </div>

    <div class="container">
        <h2>Log Cyber Security Incident</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Incident Title (e.g., Ransomware Attack)" required>
            <textarea name="description" placeholder="Provide incident intelligence / forensics details..." required></textarea>
            <select name="severity">
                <option value="Low">Low Severity</option>
                <option value="Medium">Medium Severity</option>
                <option value="High">High Severity</option>
                <option value="Critical">Critical Severity</option>
            </select>
            <button type="submit" name="report">Submit Incident Report</button>
        </form>
        <a href="view_incidents.php" class="view-btn">➔ View Incident Logs & Search Platform</a>
    </div>
</body>
</html>
