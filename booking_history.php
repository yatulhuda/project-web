<?php
include('db.php');

// Initialize variables for form fields
$carPlate = $parkArea = $startTime = $duration = '';
$bookingId = null;

// Fetch booking information if bookingId is provided
if (isset($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Fetch booking information
    $query = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $booking = $result->fetch_assoc();

            // Assign booking details to form fields
            $carPlate = $booking['carPlate'];
            $parkArea = $booking['parkArea'];
            $startTime = $booking['startTime'];
            $duration = $booking['duration'];
        } else {
            echo "No booking found with the provided ID.";
            exit();
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
} else {
    // Fetch all booking history
    $query = "SELECT * FROM bookings";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error fetching booking history: " . mysqli_error($conn);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        body {
            background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(img/fkom.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 110vh;
        }
        .nav {
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 100px;
            line-height: 100px;
            z-index: 100;
        }
        .nav-logo p {
            color: white;
            font-size: 25px;
            font-weight: 600;
        }
        .nav-button .btn {
            width: 130px;
            height: 40px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.4);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: .3s ease;
        }
        #logoutBtn {
            margin-left: 15px;
            color: black;
        }
        .btn.white-btn {
            background: white;
        }
        .btn.white-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .side-bar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            width: 290px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }
        .side-bar .menu {
            width: 100%;
            margin-top: 80px;
        }
        .side-bar .menu .item {
            position: relative;
            cursor: pointer;
        }
        .side-bar .menu .item a {
            color: white;
            font-size: 16px;
            text-decoration: none;
            display: block;
            padding: 5px 30px;
            line-height: 60px;
        }
        .side-bar .menu .item a:hover {
            background: #00b4ab;
            transition: 0.3s ease;
        }
        .side-bar .menu .item .sub-menu {
            display: none;
            background: rgba(255, 255, 255, 0.1);
        }
        .side-bar .menu .item.active .sub-menu {
            display: block;
        }
        .side-bar .menu .item .sub-menu a {
            padding-left: 50px;
        }
        .content {
            margin-left: 300px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }
        .content h2 {
            margin-bottom: 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table th, .content table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .content table th {
            background-color: #00b4ab;
            color: white;
        }
        .content table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #00b4ab;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #007f7e;
        }
    </style>
    <script>


    function showBookingHistory() {
        document.getElementById("bookingHistory").style.display = "block";
    }
  
    </script>
</head>
<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <p>FKPark</p>
            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="logoutBtn">Log Out</button>
            </div>
        </nav>
        <div class="side-bar">
            <div class="menu">
                <div class="item"><a href="#">Profile</a></div>
                <div class="item"><a href="#">Registration</a></div>
                <div class="item"><a href="#">Parking</a></div>
                <div class="item"><a href="#">Booking</a></div>
                <div class="item"><a href="#">Summon</a></div>
                <div class="item"><a href="#">Report</a></div>
                <div class="item"><a href="admin_dashboard.php">Admin Dashboard</a></div>
            </div>
        </div>
        <div class="content">
            <h2>Booking History</h2>
            <div id="bookingHistory">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Plate Number</th>
                                <th>Parking Area</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($booking = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['carPlate']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['parkArea']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['startTime']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['endTime']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No booking history found.</p>
                <?php endif; ?>
            </div>
            <?php if ($bookingId): ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>



