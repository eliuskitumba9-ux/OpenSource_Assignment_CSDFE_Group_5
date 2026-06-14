<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username'])) { header("Location: index.php"); exit(); }

$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search_id'])) {
    $search_id = $_GET['search_id'];
    $result = $conn->query("SELECT * FROM incidents WHERE incident_id = $search_id");
} else {
    $result = $conn->query("SELECT * FROM incidents ORDER BY incident_id DESC");
}
?>
<!DOCTYPE html>
<html>
<head><title>Incident Logs</title></head>
<body>
    <h2>Security Incident Logs</h2>
    <a href="dashboard.php">Back to Dashboard</a><br><br>
    
    <form method="GET">
        <input type="number" name="search_id" placeholder="Search by Incident ID" required>
        <button type="submit" name="search">Search</button>
        <a href="view_incidents.php">Reset</a>
    </form>
    
    <table border="1" cellpadding="10" style="margin-top: 20px; width: 100%;">
        <tr>
            <th>Incident ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Severity</th>
            <th>Reported By</th>
            <th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['incident_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><strong><?php echo $row['severity']; ?></strong></td>
            <td><?php echo $row['reported_by']; ?></td>
            <td><?php echo $row['date_reported']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
