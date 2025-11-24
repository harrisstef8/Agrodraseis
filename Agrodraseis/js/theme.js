const checkbox = document.querySelector(".toggle-checkbox");
const root = document.documentElement;

// Αν υπάρχει αποθηκευμένο θέμα → φόρτωσέ το
const savedTheme = localStorage.getItem("theme") || "light";
root.setAttribute("data-theme", savedTheme);
checkbox.checked = savedTheme === "dark";

// Όταν αλλάζει η επιλογή
checkbox.addEventListener("change", () => {
  const newTheme = checkbox.checked ? "dark" : "light";
  root.setAttribute("data-theme", newTheme);
  localStorage.setItem("theme", newTheme);
});

// ===== Απόκρυψη header όταν γίνεται scroll προς τα κάτω =====
let lastScrollTop = 0;
const header = document.querySelector(".site-header");

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

  if (currentScroll > lastScrollTop && currentScroll > 100) {
    // κύλιση προς τα κάτω -> κρύψε header
    header.classList.add("hide");
  } else {
    // κύλιση προς τα πάνω -> δείξε header
    header.classList.remove("hide");
  }

  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // για ασφαλή reset
});

