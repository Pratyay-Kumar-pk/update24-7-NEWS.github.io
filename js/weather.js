const weatherApiKey = "X3ARA8KUKFTL69XS8AYCGPQ6U";
const weatherApiUrl = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline";
const geoApiKey = "09671d614ff7436da25582fb55a2a424"; // Replace with your OpenCage API key
const geoApiUrl = "https://api.opencagedata.com/geocode/v1/json";

const searchBox = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const weatherIcon = document.querySelector(".weather-icon");

// Define a mapping from weather condition codes to Weather Icons class names
const weatherIcons = {
    "clear-day": "wi-day-sunny",
    "clear-night": "wi-night-clear",
    "rain": "wi-rain",
    "snow": "wi-snow",
    "sleet": "wi-sleet",
    "wind": "wi-strong-wind",
    "fog": "wi-fog",
    "cloudy": "wi-cloudy",
    "partly-cloudy-day": "wi-day-cloudy",
    "partly-cloudy-night": "wi-night-alt-cloudy",
    // Add more mappings as needed
    "default": "wi-na" // Default icon
};

async function checkWeather(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();

        console.log(data); // Log the data to inspect the structure

        if (response.ok) {
            const weatherConditions = data.currentConditions.conditions;
            const iconCode = data.currentConditions.icon; // Assuming the API provides an icon code

            document.querySelector(".city").innerHTML = data.address; // Adjusted for correct field
            document.querySelector(".temp").innerHTML = Math.round(data.currentConditions.temp) + "°C"; // Adjusted for correct field
            document.querySelector(".humidity").innerHTML = data.currentConditions.humidity + "%"; // Adjusted for correct field
            document.querySelector(".wind").innerHTML = data.currentConditions.windspeed + " km/h"; // Adjusted for correct field

            // Set weather icon dynamically
            console.log("Weather Conditions:", weatherConditions); // Log the weather conditions
            console.log("Weather Icon Code:", iconCode); // Log the icon code

            // Use the icon code to get the corresponding Weather Icons class name
            const iconClass = weatherIcons[iconCode] || weatherIcons["default"];
            weatherIcon.className = `weather-icon wi ${iconClass}`;
        } else {
            // Handle invalid city or other errors
            console.error("Error:", data.message);
            document.querySelector(".city").innerHTML = "City not found";
            document.querySelector(".temp").innerHTML = "-";
            document.querySelector(".humidity").innerHTML = "-";
            document.querySelector(".wind").innerHTML = "-";
            weatherIcon.className = `weather-icon wi ${weatherIcons["default"]}`; // Default icon for errors
        }
    } catch (error) {
        console.error("Error:", error);
        document.querySelector(".city").innerHTML = "Error fetching data";
        document.querySelector(".temp").innerHTML = "-";
        document.querySelector(".humidity").innerHTML = "-";
        document.querySelector(".wind").innerHTML = "-";
        weatherIcon.className = `weather-icon wi ${weatherIcons["default"]}`; // Default icon for errors
    }
}

async function getCityName(lat, lon) {
    const url = `${geoApiUrl}?q=${lat}+${lon}&key=${geoApiKey}`;
    try {
        const response = await fetch(url);
        const data = await response.json();
        if (response.ok && data.results.length > 0) {
            return data.results[0].components.city || data.results[0].components.town || data.results[0].components.village || "Unknown location";
        } else {
            console.error("Error fetching city name:", data.status.message);
            return "Unknown location";
        }
    } catch (error) {
        console.error("Error fetching city name:", error);
        return "Unknown location";
    }
}

// Get the search input element
const searchInput = document.querySelector(".search input");

// Add event listener for input event
searchInput.addEventListener("input", () => {
    // Get the current value of the input field
    let inputText = searchInput.value.trim();

    // Capitalize the first letter
    inputText = inputText.charAt(0).toUpperCase() + inputText.slice(1);

    // Update the input field with the capitalized text
    searchInput.value = inputText;
});


async function fetchWeatherByLocation(lat, lon) {
    const city = await getCityName(lat, lon);
    const url = `${weatherApiUrl}/${city}?unitGroup=metric&include=current&contentType=json&key=${weatherApiKey}`;
    checkWeather(url);
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                fetchWeatherByLocation(lat, lon);
            },
            (error) => {
                console.error("Error getting location:", error);
                alert("Location access is required to fetch weather data for your current location.");
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

searchBtn.addEventListener("click", () => {
    const city = searchBox.value.trim();
    if (city) {
        const url = `${weatherApiUrl}/${city}?unitGroup=metric&include=current&contentType=json&key=${weatherApiKey}`;
        checkWeather(url);
    } else {
        alert("Please enter a city name");
    }
});

// Initial check for user's location
getLocation();
