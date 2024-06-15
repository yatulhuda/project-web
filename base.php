<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <title>Base</title>
    </head>
    <style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
}
body{
    background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(img/fkom.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
.wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 110vh;
}
.nav{
    position: fixed;
    top: 0;
    display: flex;
    justify-content: space-around;
    width: 100%;
    height: 100px;
    line-height: 100px;
    z-index: 100;
}
.nav-logo p{
    color: white;
    font-size: 25px;
    font-weight: 600;
}
.nav-button .btn{
    width: 130px;
    height: 40px;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: .3s ease;
}
#logoutBtn{
    margin-left: 15px;
    color: black;
}
.btn.white-btn{
    background: white;
}
.btn.white-btn:hover{
    background: rgba(255, 255, 255, 0.3);
}
.side-bar{
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    width: 290px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
}
.side-bar .menu{
    width: 100%;
    margin-top: 80px;
}
.side-bar .menu .item{
    position: relative;
    cursor: pointer;
}
.side-bar .menu .item a{
    color: white;
    font-size: 16px;
    text-decoration: none;
    display: block;
    padding: 5px 30px;
    line-height: 60px;
}
.side-bar .menu .item a:hover{
    background: #00b4ab;
    transition: 0.3s ease;
}
.side-bar .menu .toggle-btn{
    background: rgba(255, 255, 255, 0);
    font-size: 30px;
    cursor: pointer;
    color: white;
    padding: 10px 15px;
    border: none;
}
</style>
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
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        const side-bar = document.getElementById('side-bar');
                        const toggleBtn = document.getElementById('toggleBtn');

                        toggleBtn.addEventListener('click', function(){
                            if (side-bar.style.transform === 'translateX(0px)'){
                                side-bar.style.transform = 'translateX(-250px)';
                            } else{
                                side-bar.style.transform = 'translateX(0px)';
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </body>
</html>