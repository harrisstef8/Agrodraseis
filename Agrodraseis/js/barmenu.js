document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("menuToggle");
  const dropdown = document.getElementById("dropdownMenu");

  toggleBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdown.classList.toggle("show");
  });

  document.addEventListener("click", (e) => {
    if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
      dropdown.classList.remove("show");
    }
  });
});
