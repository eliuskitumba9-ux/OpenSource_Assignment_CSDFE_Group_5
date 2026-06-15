<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username'])) { header("Location: index.php"); exit(); }

if (isset($_GET['search']) && !empty($_GET['search_id'])) {
    $search_id = intval($_GET['search_id']);
    $result = $conn->query("SELECT * FROM incidents WHERE incident_id = $search_id");
} else {
    $result = $conn->query("SELECT * FROM incidents ORDER BY incident_id DESC");
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>SOC - Incident Logs</title>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; }
        .header-area { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { color: #58a6ff; margin: 0; }
        .back-btn { background-color: #21262d; color: #c9d1d9; padding: 10px 15px; border-radius: 6px; text-decoration: none; border: 1px solid #30363d; font-size: 14px; }
        .search-box { background-color: #161b22; padding: 15px; border-radius: 6px; border: 1px solid #30363d; margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
        input[type="number"] { padding: 10px; border-radius: 6px; border: 1px solid #30363d; background-color: #0d1117; color: #c9d1d9; width: 200px; }
        .btn-search { background-color: #1f6feb; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-reset { color: #8b949e; text-decoration: none; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; background-color: #161b22; border-radius: 8px; overflow: hidden; border: 1px solid #30363d; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #30363d; }
        th { background-color: #1f6feb; color: white; }
        tr:hover { background-color: #21262d; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .Low { background-color: #238636; color: white; }
        .Medium { background-color: #d29922; color: black; }
        .High { background-color: #db6d28; color: white; }
        .Critical { background-color: #f85149; color: white; }
    </style>
</head>
<body>
    <div class="header-area">
        <h2>Security Incident Master Logs</h2>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>

    <div class="search-box">
        <form method="GET" style="display: flex; align-items: center; gap: 10px; width: 100%;">
            <input type="number" name="search_id" placeholder="Enter Incident ID to query..." required>
            <button type="submit" name="search" class="btn-search">Query Database</button>
            <a href="view_incidents.php" class="btn-reset">Reset Filter</a>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Incident Title</th>
            <th>Forensic Details / Description</th>
            <th>Severity</th>
            <th>Analyst</th>
            <th>Timestamp</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td>#<?php echo $row['incident_id']; ?></td>
            <td style="color: #58a6ff; font-weight: bold;"><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><span class="badge <?php echo $row['severity']; ?>"><?php echo $row['severity']; ?></span></td>
            <td><?php echo $row['reported_by']; ?></td>
            <td><?php echo $row['date_reported']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
