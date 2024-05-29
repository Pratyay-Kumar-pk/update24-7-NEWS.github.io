<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b48e60f31f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
    <link rel="stylesheet" href="css/weather.css" type="text/css" media="all" />
    <link rel="shortcut icon" type="x-icon" href="assets/weather.png">
    <title>Weather</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <div class="sign-in-form form">
                    <div class="card">
                        <div class="search">
                            <input type="text " placeholder="Enter city name" spellcheck="false">
                            <button><i class="fa-solid fa-search fa-lg fa-beat"></i></button>
                        </div>
                        <div class="weather">
                            <i class="weather-icon wi"></i>
                            <h1 class="temp"></h1>
                            <h2 class="city"></h2>
                            <div class="details">
                                <div class="col">
                                    <i class="fa-solid fa-water"></i>
                                    <div>
                                        <p class="humidity"></p>
                                        <p>Humidity</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <i class="fa-solid fa-wind"></i>
                                    <div>
                                        <p class="wind"></p>
                                        <p>Wind Speed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>CHECK WEATHER UPDATES</h3>
                    <button class="btn transparent" id="sign-up-btn">
                        <a href="index.php">BACK TO HOME</a>
                    </button>
                </div>
                <img src="images/weather-animate.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="js/weather.js"></script>
</body>

</html>