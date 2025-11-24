<?php include "header.php"; ?>
<?php
// weather.php
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Πρόγνωση Καιρού | AgroΔράσεις</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: "Inter", sans-serif;
      background: linear-gradient(120deg, #e4f5dc, #d4e3c0, #a8c48a);
      color: #1b7a3e;
      margin: 0;
      padding: 0;
    }

    .weather-page {
      max-width: 900px;
      margin: 80px auto 50px;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      padding: 30px;
      text-align: center;
    }

    h2 {
      margin-top: 0;
      font-size: 26px;
      color: #1b7a3e;
    }

    form {
      margin-bottom: 25px;
      display: flex;
      justify-content: center;
      gap: 8px;
    }

    input[type="text"] {
      padding: 10px 14px;
      width: 65%;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    button {
      background-color: #1b7a3e;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #166832;
    }

    .current-weather img {
      width: 80px;
      height: 80px;
    }

    .forecast {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 10px;
      margin-top: 25px;
    }

    .forecast-day {
      background: #f3f6f2;
      border-radius: 14px;
      padding: 10px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .forecast-day img {
      width: 50px;
      height: 50px;
    }

    .forecast-day p {
      margin: 5px 0;
      font-size: 14px;
    }
    
    body {
      font-family: "Inter", sans-serif;
      color: #1b7a3e;
      margin: 0;
      padding: 0;
      /* === Φόντο εικόνας === */
      background: url("../images/weather.jpg") no-repeat center center fixed;
      background-size: cover;
      background-attachment: fixed;
    }

  </style>
</head>
<body>
  <div class="weather-page">
    <h2>Πρόγνωση Καιρού</h2>
    <form id="weatherForm">
      <input type="text" id="cityInput" placeholder="Αναζήτηση πόλης...">
      <button type="submit">Αναζήτηση</button>
    </form>

    <div class="current-weather" id="currentWeather"></div>
    <div class="forecast" id="forecast"></div>
  </div>

  <script>
    const apiKey = "....";
    const currentDiv = document.getElementById("currentWeather");
    const forecastDiv = document.getElementById("forecast");
    const form = document.getElementById("weatherForm");
    const input = document.getElementById("cityInput");

    // === 1️⃣ Όταν ανοίγει η σελίδα: δείξε τον καιρό του Λαγκαδά ===
    window.addEventListener("DOMContentLoaded", () => {
      loadWeather("Lagkadas,GR");
    });

    // === 2️⃣ Αναζήτηση πόλης ===
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const city = input.value.trim();
      if (!city) return alert("Πληκτρολογήστε μια πόλη!");
      loadWeather(city);
    });

    // === 3️⃣ Συνάρτηση που φέρνει δεδομένα και τα εμφανίζει ===
    async function loadWeather(city) {
      try {
        // Τρέχων καιρός
        const weatherURL = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=el&appid=${apiKey}`;
        const weatherRes = await fetch(weatherURL);
        const weatherData = await weatherRes.json();

        if (weatherData.cod !== 200) {
          currentDiv.innerHTML = `<p>Δεν βρέθηκε η πόλη "${city}".</p>`;
          forecastDiv.innerHTML = "";
          return;
        }

        currentDiv.innerHTML = `
          <h3>${weatherData.name}</h3>
          <img src="https://openweathermap.org/img/wn/${weatherData.weather[0].icon}@2x.png" alt="icon">
          <p><strong>${weatherData.main.temp.toFixed(1)}°C</strong> – ${weatherData.weather[0].description}</p>
          <p>💧 Υγρασία: ${weatherData.main.humidity}% | 💨 Άνεμος: ${weatherData.wind.speed} m/s</p>
        `;

        // Πρόγνωση 5 ημερών
        const forecastURL = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&units=metric&lang=el&appid=${apiKey}`;
        const forecastRes = await fetch(forecastURL);
        const forecastData = await forecastRes.json();

        const days = {};
        forecastData.list.forEach(item => {
          const date = item.dt_txt.split(" ")[0];
          if (!days[date]) days[date] = item;
        });

        forecastDiv.innerHTML = Object.keys(days).slice(0, 5).map(date => {
          const d = new Date(date);
          const dayName = d.toLocaleDateString("el-GR", { weekday: "long" });
          const info = days[date];
          return `
            <div class="forecast-day">
              <p><strong>${dayName}</strong></p>
              <img src="https://openweathermap.org/img/wn/${info.weather[0].icon}.png" alt="icon">
              <p>${info.main.temp.toFixed(1)}°C</p>
              <p>${info.weather[0].description}</p>
            </div>
          `;
        }).join("");
      } catch (err) {
        currentDiv.innerHTML = `<p>Σφάλμα φόρτωσης δεδομένων. Προσπαθήστε ξανά.</p>`;
        console.error("Σφάλμα:", err);
      }
    }
  </script>

<?php include "footer.php"; ?>
<script src="../js/scroll.js" defer></script>
</body>
</html>