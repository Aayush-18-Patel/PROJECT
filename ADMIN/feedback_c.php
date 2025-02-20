<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Feedback</title>

</head>

<body>

<header class="header">
    <nav class="nav container">
        <div class="logo" style="margin-left: 0px;">SHREEJI ENTERPRISE</div>
        <ul class="nav-links">
            <li><a href="index.html">Dashboard</a></li>
            <li><a href="feedback.php">Feedbacks</a></li>
        </ul>
    </nav>
</header>

<br><br><br><br><br>

<div class="container mt-3" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px;">
    <button type="button" class="btn btn-secondary" onclick="window.location.href='feedback.php'">Jobseeker Feedback</button>
    <h1 style="margin: 0; flex-grow: 1; text-align: center; color: #004D40;">Company Feedbacks</h1>
</div>

<!-- Scrollable Table Wrapper -->
<div style="width: 80%; margin: auto; border: 3px solid black; padding: 10px; border-radius: 8px; overflow: hidden;">
    <div style="max-height: 620px; overflow-y: auto;">
        <table class="table table-striped table-bordered" style="width: 100%; font-size: 19px; text-align: center;">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="padding: 10px;">#</th>
                    <th scope="col" style="padding: 10px;">Email</th>
                    <th scope="col" style="padding: 10px;">Rating</th>
                    <th scope="col" style="padding: 10px;">Comment</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    require_once 'config.php'; // Database connection

                    $sql = "SELECT * FROM feedback_c"; // Fetch all feedback records
                    $result = $con->query($sql);
                    $count = 1; // Auto-increment for row number

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <th scope='row' style='padding: 10px;'>$count</th>
                                <td style='padding: 10px;'>{$row['email']}</td>
                                <td style='padding: 10px;'>{$row['rating']}</td>
                                <td style='padding: 10px;'>{$row['comment']}</td>
                            </tr>";
                        $count++;
                    }

                    $con->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
