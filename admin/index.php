<?php
include '../db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/users_styles.css">
    <link rel="stylesheet" href="css/add_users_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Portal Admin</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#dashboard" class="menu-item active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#settings" class="menu-item"><i class="fas fa-chart-bar"></i> Number Of Votes</a></li>
                     <li><a href="#suara" class="menu-item"><i class="fas fa-list"></i> Suara</a></li>
                    <li><a href="#users" class="menu-item"><i class="fas fa-users"></i> Users</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>Welcome, <?php echo $_SESSION['name'] ?></h1>
                <div class="profile">
                    <a class="logout-link" href="../logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a></a>
                </div>
            </header>
            <section class="content">
                <div id="dashboard" class="section">
                    <h2>Dashboard</h2>
                 <p><?php include "hasil.php" ?></p>

                   
                  
                </div>
                <div id="users" class="section" style="display: none;">
                    <div><?php include "users.php" ?></div>
                </div>
                   <div id="suara" class="section" style="display: none;">
                    <div><?php include "suara.php" ?></div>
                </div>
                <div id="settings" class="section" style="display: none;">
                    <div><?php include "numberVotes.php" ?></div>
                </div>
            </section>
        </main>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
