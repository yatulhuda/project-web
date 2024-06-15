<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        .content {
            margin-left: 300px;
            padding: 20px;
        }
        .dashboard {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .dashboard h3 {
            margin-bottom: 20px;
        }
        .dashboard canvas {
            width: 100%;
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
                <div class="item"><a href="booking.php">Booking</a></div>
                <div class="item"><a href="#">Summon</a></div>
                <div class="item"><a href="#">Report</a></div>
                <div class="item"><a href="admin_dashboard.php">Admin Dashboard</a></div>
            </div>
        </div>
        <div class="content">
            <h2>Admin Dashboard</h2>
            <div class="dashboard">
                <h3>Bookings Overview</h3>
                <canvas id="bookingsChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookingsChart').getContext('2d');
        const bookingsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Area 1', 'Area 2', 'Area 3'],
                datasets: [{
                    label: '# of Bookings',
                    data: [12, 19, 3], // Example data, replace with dynamic data
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
