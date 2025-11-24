const apiKey = "4b0e3cf3e0a0dc399a235e2c38ffc07a";

/* 👉 Μετατροπή ελληνικών (και με τόνους) σε αγγλικά */
function normalizeGreekCity(name) {
  // Αφαίρεση τόνων
  name = name
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/ς/g, "σ")
    .trim()
    .toLowerCase();

  // Χάρτης ελληνικών → λατινικών
  const map = {
    "α":"a","β":"v","γ":"g","δ":"d","ε":"e","ζ":"z","η":"i",
    "θ":"th","ι":"i","κ":"k","λ":"l","μ":"m","ν":"n","ξ":"x",
    "ο":"o","π":"p","ρ":"r","σ":"s","τ":"t","υ":"y","φ":"f",
    "χ":"h","ψ":"ps","ω":"o"
  };

  return name.replace(/[α-ω]/g, c => map[c] || c);
}

/* 👉 Η πόλη που θέλουμε να φαίνεται στο banner */
let cityInput = "Λαγκαδάς"; // Μπορεί να είναι ΚΑΙ ελληνικά!

let city = normalizeGreekCity(cityInput); // Μετατροπή σε API-friendly μορφή

// Καθυστέρηση εμφάνισης banner
window.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.getElementById("weatherBanner").classList.add("visible");
  }, 3000);

  loadWeather();
});

// Φόρτωμα καιρού από OpenWeather
function loadWeather() {
  fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&lang=el&appid=${apiKey}`)
    .then(res => res.json())
    .then(data => {
      if (data.cod !== 200) {
        document.getElementById("weatherTemp").textContent = "--°C";
        document.getElementById("weatherDesc").textContent = "Μη διαθέσιμο";
        return;
      }

      const icon = data.weather[0].icon;
      const temp = data.main.temp.toFixed(1);
      const desc = data.weather[0].description;

      document.getElementById("weatherIcon").src =
        `https://openweathermap.org/img/wn/${icon}.png`;

      document.getElementById("weatherTemp").textContent = `${temp}°C`;
      document.getElementById("weatherDesc").textContent =
        desc.charAt(0).toUpperCase() + desc.slice(1);
    })
    .catch(err => {
      console.error("Σφάλμα καιρού:", err);
    });
}

/* Κουμπί κλεισίματος banner */
document.getElementById("closeWeather").addEventListener("click", () => {
  const banner = document.getElementById("weatherBanner");
  banner.style.opacity = "0";
  banner.style.transform = "translateY(-10px)";
  setTimeout(() => banner.remove(), 800);
});
