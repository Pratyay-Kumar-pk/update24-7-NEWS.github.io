// API
const API_KEY = "e383b84f108b472bb5bba9035e72266b";
const url = "https://newsapi.org/v2/everything?q=";

// Define the getFormattedDate function
function getFormattedDate(date) {
    // Ensure the passed argument is a Date object
    if (!(date instanceof Date)) {
        throw new Error("Invalid argument: expected a Date object");
    }

    // Get the day, month, and year from the date
    const day = String(date.getDate()).padStart(2, '0'); // Add leading zero if needed
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based in JavaScript
    const year = date.getFullYear();

    // Format the date as YYYY-MM-DD
    const formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
}

// Add event listener for window load
window.addEventListener("load", () => {
    const query = "india"; // Default query
    const fromDate = getFormattedDate(new Date(Date.now() - 7 * 24 * 60 * 60 * 1000)); // 7 days ago
    const toDate = getFormattedDate(new Date()); // Current date
    fetchNews(query, fromDate, toDate);
});

// Define the fetchNews function
async function fetchNews(query, fromDate, toDate) {
    const res = await fetch(`${url}${query}&from=${fromDate}&to=${toDate}&language=en&apiKey=${API_KEY}`);
    const data = await res.json();
    const sortedArticles = data.articles.sort((a, b) => new Date(b.publishedAt) - new Date(a.publishedAt)); // Sort articles by date
    const shuffledArticles = shuffleArray(sortedArticles); // Shuffle articles
    bindData(shuffledArticles);
}

// Define the shuffleArray function
function shuffleArray(array) {
    // Fisher-Yates (Knuth) Shuffle Algorithm
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Define the bindData function
function bindData(articles) {
    const cardsContainer = document.getElementById("cards-container");
    const newsCardTemplate = document.getElementById("template-news-card");

    cardsContainer.innerHTML = "";

    articles.forEach((article) => {
        if (!article.urlToImage) return;
        const cardClone = newsCardTemplate.content.cloneNode(true);
        fillDataInCard(cardClone, article);
        cardsContainer.appendChild(cardClone);
    });
}

// Define the fillDataInCard function
function fillDataInCard(cardClone, article) {
    const newsImg = cardClone.querySelector("#news-img");
    const newsTitle = cardClone.querySelector("#news-title");
    const newsSource = cardClone.querySelector("#news-source");
    const newsDesc = cardClone.querySelector("#news-desc");

    newsImg.src = article.urlToImage;
    newsTitle.innerHTML = article.title;
    newsDesc.innerHTML = article.description;

    const date = new Date(article.publishedAt).toLocaleString("en-US", {
        timeZone: "Asia/Jakarta",
    });

    newsSource.innerHTML = `${article.source.name} · ${date}`;

    cardClone.firstElementChild.addEventListener("click", () => {
        window.open(article.url, "_blank");
    });
}

// Define navigation item click handler
let curSelectedNav = null;
function onNavItemClick(id) {
    const query = id;
    const fromDate = getFormattedDate(new Date(Date.now() - 7 * 24 * 60 * 60 * 1000)); // 7 days ago
    const toDate = getFormattedDate(new Date()); // Current date
    fetchNews(query, fromDate, toDate);
    const navItem = document.getElementById(id);
    curSelectedNav?.classList.remove("active");
    curSelectedNav = navItem;
    curSelectedNav.classList.add("active");
}

// Define search button click handler
const searchButton = document.getElementById("search-button");
const searchText = document.getElementById("search-text");
const searchIcon = document.getElementById("search-icon");

function performSearch() {
    const query = searchText.value;
    if (!query) return;
    const fromDate = getFormattedDate(new Date(Date.now() - 7 * 24 * 60 * 60 * 1000)); // 7 days ago
    const toDate = getFormattedDate(new Date()); // Current date
    fetchNews(query, fromDate, toDate);
    curSelectedNav?.classList.remove("active");
    curSelectedNav = null;
}

searchButton.addEventListener("click", performSearch);
searchIcon.addEventListener("click", performSearch);

function reload() {
    window.location.reload();
}

// DARK MODE
var darkmode = document.getElementById("darkmode");
var logo = document.getElementById("logo");

// Check if dark mode preference is stored in local storage
var isDarkMode = localStorage.getItem("darkMode") === "true";

// Set initial dark mode state based on local storage
if (isDarkMode) {
    document.body.classList.add("dark-theme");
    darkmode.className = "fa-solid fa-circle-half-stroke fa-xl";
    logo.src = "assets/dark-logo.png"; // Set logo to dark mode logo
} else {
    document.body.classList.remove("dark-theme");
    darkmode.className = "fa-solid fa-circle-half-stroke fa-xl";
    logo.src = "assets/lite-logo.png"; // Set logo to light mode logo
}

darkmode.onclick = function () {
    document.body.classList.toggle("dark-theme");
    if (document.body.classList.contains("dark-theme")) {
        darkmode.className = "fa-solid fa-circle-half-stroke fa-xl";
        logo.src = "assets/dark-logo.png"; // Change logo to dark mode logo
        // Store dark mode preference in local storage
        localStorage.setItem("darkMode", "true");
    } else {
        darkmode.className = "fa-solid fa-circle-half-stroke fa-xl";
        logo.src = "assets/lite-logo.png"; // Change logo to light mode logo
        // Remove dark mode preference from local storage
        localStorage.removeItem("darkMode");
    }
}

// Define toggleMenu function
function toggleMenu() {
    const hamburgerMenu = document.getElementById("hamburgerMenu");
    hamburgerMenu.classList.toggle("change");
    const navLinks = document.getElementById("navLinks");
    navLinks.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", function () {
    const searchBarDesktop = document.getElementById("searchBarDesktop");
    const searchBarMobile = document.getElementById("searchBarMobile");
    const navbar = document.getElementById("navbar");

    function moveSearchBar() {
        if (window.innerWidth <= 500) {
            if (!searchBarMobile.contains(document.getElementById("search-text"))) {
                searchBarMobile.appendChild(searchBarDesktop.querySelector("#search-text"));
                searchBarMobile.appendChild(searchBarDesktop.querySelector("#search-button"));
                searchBarMobile.appendChild(searchBarDesktop.querySelector(".search-icon"));
            }
        } else {
            if (!searchBarDesktop.contains(document.getElementById("search-text"))) {
                searchBarDesktop.appendChild(searchBarMobile.querySelector("#search-text"));
                searchBarDesktop.appendChild(searchBarMobile.querySelector("#search-button"));
                searchBarDesktop.appendChild(searchBarMobile.querySelector(".search-icon"));
            }
        }
    }

    window.addEventListener("resize", moveSearchBar);
    moveSearchBar();  // Initial call
});
