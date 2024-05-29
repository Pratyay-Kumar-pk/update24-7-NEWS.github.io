<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b48e60f31f.js" crossorigin="anonymous"></script>
    <title src="">Updates 24x7</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="x-icon" href="assets/news-icon.png">
</head>

<body>
    <nav>
        <div class="main-nav container flex" id="navbar">
            <a href="#" onclick="reload()" class="logo">
                <img src="assets/lite-logo.png" alt="logo" id="logo">
            </a>
            <div class="hamburger-menu" id="hamburgerMenu" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="nav-links" id="navLinks">
                <ul class="flex">
                    <li class="hover-link nav-item" id="sports" onclick="onNavItemClick('sports')">Sports</li>
                    <li class="hover-link nav-item" id="entertainment" onclick="onNavItemClick('entertainment')">Entertainment</li>
                    <li class="hover-link nav-item" id="politics" onclick="onNavItemClick('politics')">Politics</li>
                    <li class="hover-link nav-item" id="global" onclick="onNavItemClick('global')">Global</li>
                    <li class="hover-link nav-item" id="technology" onclick="onNavItemClick('technology')">Tech</li>
                    <a href="#contact-us">Contact us</a>
                </ul>
                <ul class="flex more-links" id="more-links">
                    <li class="hover-link nav-item" id="geopolitics" onclick="onNavItemClick('geopolitics')">Geopolitics</li>
                    <li class="hover-link nav-item" id="finance" onclick="onNavItemClick('finance')">Finance</li>
                    <li class="hover-link nav-item" id="buisness" onclick="onNavItemClick('buisness')">Buisness</li>
                    <li class="hover-link nav-item" id="lifestyle" onclick="onNavItemClick('lifestyle')">Lifestyle</li>
                    <li class="hover-link nav-item" id="bollywood" onclick="onNavItemClick('bollywood')">Bollywood</li>
                </ul>
                <?php if (isset($_SESSION['name'])) {  ?>
                    <div class="logout mobile-only">
                        <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                <?php } else { ?>
                    <div class="mobile-only">
                        <a id="login" href="login.php"><i class="fa fa-sign-in"></i>Login</a>
                    </div>
                <?php } ?>
                <!-- New search bar container for mobile view -->
                <div class="search-bar-mobile flex" id="searchBarMobile"></div>
            </div>
            <div class="search-bar flex" id="searchBarDesktop">
                <input id="search-text" type="text" class="news-input" placeholder="e.g. Science">
                <button id="search-button" class="search-button">Search</button>
                <div class="search-icon" id="search-icon">
                    <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                </div>
            </div>
            <i class="fa-solid fa-circle-half-stroke fa-xl" id="darkmode"></i>
            <?php if (isset($_SESSION['name'])) {  ?>
                <div class="logout desktop-only">
                    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            <?php } else { ?>
                <a id="login" href="login.php" class="desktop-only"><i class="fa fa-sign-in"></i>Login</a>
            <?php } ?>
            <a href="weather.php"><i class="fa-solid fa-smog fa-xl"></i></a>
        </div>
        <div class="user">
            <?php if (isset($_SESSION['name'])) {
                echo '<span class="welcome"> <h4>&nbsp; Welcome &nbsp;</span>' . htmlspecialchars($_SESSION['name']);
            } ?>
        </div>
    </nav>
    <main>
        <div class="cards-container container flex" id="cards-container">
        </div>
    </main>
    <template id="template-news-card">
        <div class="card">
            <div class="card-header">
                <img src="https://via.placeholder.com/400x200" onerror="this.onerror=null; this.src='assets/Upadates 24x7 logo.png';" alt="Upates 24x7" id="news-img">
            </div>
            <div class="card-content">
                <h3 id="news-title">This is the Title</h3>
                <h6 class="news-source" id="news-source">End Gadget 26/08/2023</h6>
                <p class="news-desc" id="news-desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae
                    saepe quis voluptatum quisquam vitae doloremque facilis molestias quae ratione cumque!</p>
            </div>
        </div>
    </template>
    <footer class="footer-distributed" id="contact-us">

        <div class="footer-left">
            <div class="company-name">
                <h3>Updates<span>24x7</span></h3>
                <div class="footer-logo">
                    <img src="assets/news-icon.png" alt="logo" id="logo">
                </div>
            </div>
            <p class="footer-links">
                <a href="#" class="link-1"><i class="fa-solid fa-house"></i>&nbsp;&nbsp;HOME</a>
            </p>
        </div>

        <div class="footer-center">

            <div class="items-center">
                <i class="fa-solid fa-location-dot fa-lg"></i>
                <p><span>721657 Haldia</span> West Bengal,East Midnapore</p>
            </div>

            <div class="items-center">
                <i class="fa-solid fa-phone fa-sm"></i>
                <p>+91 7384134608</p>
            </div>

            <div class="items-center">
                <i class="fa-solid fa-envelope"></i>
                <p><a href="mailto:updates24x7.news@gmail.com">updates24x7.news@gmail.com</a></p>
            </div>

        </div>
        <div class="footer-right">

            <p class="footer-company-about">
                <span>About the company</span>
                Updates 24x7 is a go-to news website for concise global news summaries. Stay informed with updates on politics, technology, sports, entertainment, and more. We provide quick, reliable news coverage, 24 hours a day, 7 days a week. Follow us for the latest headlines and breaking stories from around the world.
            </p>

            <div class="footer-icons">
                <a href="https://www.facebook.com/profile.php?id=61560273240492&mibextid=ZbWKwL" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.linkedin.com/in/anish-pramanik-504961244" target="_blank"><i class="fa fa-linkedin"></i></a>
                <a href="https://github.com/Anish013"><i class="fa fa-github" target="_blank"></i></a>

            </div>

        </div>

    </footer>

    <script src="js/script.js"></script>
</body>

</html>