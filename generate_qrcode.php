<?php
include('db.php');

if (isset($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Fetch booking information
    $query = "SELECT * FROM bookings WHERE id = '$bookingId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);

        // Generate QR Code data
        $qrData = "Booking ID: " . $booking['id'] . "\nCar Plate: " . $booking['carPlate'] . "\nPark Area: " . $booking['parkArea'] . "\nStart Time: " . $booking['startTime'] . "\nEnd Time: " . $booking['endTime'];
        $qrData = htmlspecialchars($qrData);
    } else {
        echo "No booking found with the provided ID.";
        exit();
    }
} else {
    echo "No booking ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate QR Code</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #qrcode {
            margin: 20px auto;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .button-container {
            margin-top: 20px;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>QR Code for Booking ID: <?php echo htmlspecialchars($booking['id']); ?></h2>
        <div id="qrcode"></div>
        <div>
            <button onclick="printQRCode()">Print QR Code</button>
            <button onclick="downloadQRCode()">Download QR Code</button>
        </div>
        <br>
        <a href="view_booking.php?bookingId=<?php echo $bookingId; ?>">Back to Booking Details</a>
    </div>

    <script>
        // Generate QR code
        var qrData = `<?php echo $qrData; ?>`;
        var typeNumber = 0; // 0 means automatic type number calculation
        var errorCorrectionLevel = 'M';
        var qr = qrcode(typeNumber, errorCorrectionLevel);
        qr.addData(qrData);
        qr.make();
        document.getElementById('qrcode').innerHTML = qr.createImgTag();

        // Function to print the QR code
        function printQRCode() {
            var printContents = document.getElementById('qrcode').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        // Function to download the QR code as an image
        function downloadQRCode() {
            var qrImage = document.getElementById('qrcode').getElementsByTagName('img')[0];
            var link = document.createElement('a');
            link.href = qrImage.src;
            link.download = 'qr_code.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>


