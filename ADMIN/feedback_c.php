<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHREEJI ENTERPRISE</title>

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Custom Button Styling */
        .custom-btn {
            background-color: #004D40 !important; /* Deep teal */
            border-color: #004D40 !important;
            color: white !important; /* Ensure readable text */
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-left: -250px;
        }

        .custom-btn:hover {
            background-color: silver !important; /* Darker shade on hover */
            border-color: #00332e !important;
            color: #004D40 !important;
        }

        /* Custom Header Styling */
        .company-feedback-title {
            color: #004D40 !important;
            text-align: center;
            margin: 0;
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav container">
            <div class="logo" style="margin-left: -250px;">SHREEJI ENTERPRISE</div>
            <ul class="nav-links">
                <li><a href="index.html">Dashboard</a></li>
                <li><a href="feedback.php">Feedbacks</a></li>
                <li><a href="jobseeker.php">Jobseekers</a></li>
            </ul>
        </nav>
    </header>

    <br><br><br><br><br>

    <!-- Feedback Section -->
    <div class="container mt-3"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px;">
        <!-- Company Feedback Button -->
        <button type="button" class="btn custom-btn" onclick="window.location.href='feedback.php'">
            Jobseeker Feedback
        </button>

        <!-- Job Seeker Feedback Title -->
        <h1 class="company-feedback-title">Company Feedbacks</h1>
    </div>


    <!-- Scrollable Table Wrapper -->
    <div
        style="width: 80%; margin: auto; border: 3px solid black; padding: 10px; border-radius: 8px; overflow: hidden;">
        <div style="max-height: 620px; overflow-y: auto;">
            <table class="table table-striped table-bordered" style="width: 100%; font-size: 19px; text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="padding: 10px;">#</th>
                        <th scope="col" style="padding: 10px;">Date</th>
                        <th scope="col" style="padding: 10px;">Email</th>
                        <th scope="col" style="padding: 10px;">Rating</th>
                        <th scope="col" style="padding: 10px;">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'config.php'; // Database connection
                    
                    $sql = "SELECT * FROM feedback_c ORDER BY id DESC"; // Fetch feedback in descending order
                    $result = $con->query($sql);
                    $count = 1; // Keep numbering the same
                    
                    while ($row = $result->fetch_assoc()) {
                        // Format the created_at date to dd-mm-yyyy
                        $formatted_date = date("d-m-Y", strtotime($row['created_at']));

                        echo "<tr>
            <th scope='row' style='padding: 10px;width: 50px;'>$count</th>
            <td style='padding: 10px; width: 175px;'>$formatted_date</td> 
            <td style='padding: 10px;width: 300px;'>{$row['email']}</td>
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