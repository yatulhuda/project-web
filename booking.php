<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fkpark";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form fields
$carPlate = $parkArea = $startTime = $duration = '';

// Fetch booking information if bookingId is provided
if (isset($_GET['bookingId']) && !empty($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Fetch booking information
    $query = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $booking = $result->fetch_assoc();

        // Assign booking details to form fields
        $carPlate = $booking['carPlate'];
        $parkArea = $booking['parkArea'];
        $startTime = $booking['startTime'];
        // Calculate duration based on start and end time
        $endTime = $booking['endTime'];
        $duration = (strtotime($endTime) - strtotime($startTime)) / 3600; // Calculate duration in hours
    } else {
        echo "No booking found with the provided ID.";
        exit();
    }
} else {
    $carPlate = $parkArea = $startTime = $duration = ''; // Initialize form fields to empty strings
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carPlate = $_POST['carPlate'];
    $parkArea = $_POST['parkArea'];
    $startTime = $_POST['startTime'];
    $duration = $_POST['duration'];

    // Calculate end time based on start time and duration
    $endTime = date('Y-m-d H:i:s', strtotime($startTime) + $duration * 3600);

    // Check for booking clashes
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE parkArea=? AND (startTime BETWEEN ? AND ? OR endTime BETWEEN ? AND ?)");
    $stmt->bind_param("sssss", $parkArea, $startTime, $endTime, $startTime, $endTime);
    $stmt->execute();
    $clashResult = $stmt->get_result();

    if ($clashResult->num_rows > 0) {
        echo "Booking clash detected. Please choose another time or area.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (carPlate, parkArea, startTime, endTime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $carPlate, $parkArea, $startTime, $endTime);
        
        if ($stmt->execute()) {
            $bookingId = $stmt->insert_id;
            echo "<p>Booking successful! Redirecting to view your booking...</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'view_booking.php?bookingId=$bookingId';
                    }, 3000); // Redirect after 3 seconds
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
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
        .content {
            margin-left: 300px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }
        .content h2 {
            margin-bottom: 30px;
        }
        .content p {
            margin-bottom: 10px;
        }
        .booking-form {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .booking-form label {
            display: block;
            margin-bottom: 8px;
        }
        .booking-form input, .booking-form select, .booking-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
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
            <h2>Make Booking</h2>
            <div class="booking-form">
                <form method="post" action="process_booking.php">
                    <label for="carPlate">Car Plate Number:</label>
                    <input type="text" id="carPlate" name="carPlate" value="<?php echo htmlspecialchars($carPlate); ?>" required><br><br>
                    <label for="parkArea">Parking Area:</label>
                    <select id="parkArea" name="parkArea" required>
                        <option value="A" <?php echo $parkArea == 'A' ? 'selected' : ''; ?>>Area A</option>
                        <option value="B" <?php echo $parkArea == 'B' ? 'selected' : ''; ?>>Area B</option>
                        <option value="C" <?php echo $parkArea == 'C' ? 'selected' : ''; ?>>Area C</option>
                    </select><br><br>
                    <label for="startTime">Start Time:</label>
                    <input type="datetime-local" id="startTime" name="startTime" value="<?php echo date('Y-m-d\TH:i', strtotime($startTime)); ?>" required><br><br>
                    <label for="duration">Duration (hours):</label>
                    <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($duration); ?>" required><br><br>
                    <button type="submit" class="btn white-btn">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>