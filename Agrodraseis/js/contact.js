document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const responseBox = document.getElementById("formResponse");

  form.addEventListener("submit", async (e) => {
    e.preventDefault(); // Μην κάνει reload

    // ======= VALIDATION =======
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const phone = form.phone.value.trim();
    const service = form.service.value.trim();
    const message = form.message.value.trim();

    // Έλεγχος υποχρεωτικών πεδίων
    if (!name || !email || !phone || !service || !message) {
      showMessage("⚠️ Παρακαλώ συμπληρώστε όλα τα πεδία.", "error");
      return;
    }

    // Έλεγχος email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      showMessage("⚠️ Παρακαλώ εισάγετε ένα έγκυρο email.", "error");
      return;
    }

    // Έλεγχος τηλεφώνου (μόνο αριθμοί, 10 ψηφία)
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phone)) {
      showMessage("⚠️ Το τηλέφωνο πρέπει να έχει 10 ψηφία (μόνο αριθμούς).", "error");
      return;
    }

    // ======= Εμφάνιση προσωρινού loading =======
    showMessage("⏳ Αποστολή μηνύματος...", "loading");

    // ======= Αποστολή μέσω AJAX =======
    const formData = new FormData(form);

    try {
      const response = await fetch("php/contact_submit.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.text();

      if (result.trim() === "OK") {
        showMessage("✅ Το μήνυμα στάλθηκε επιτυχώς!", "success");
        form.reset();
      } else {
        showMessage(" " + result, "error");
      }
    } catch (error) {
      showMessage("❌ Παρουσιάστηκε σφάλμα κατά την αποστολή.", "error");
    }
  });

  // ======= Συνάρτηση εμφάνισης μηνυμάτων =======
  function showMessage(text, type) {
    responseBox.textContent = text;
    responseBox.className = ""; // Καθαρίζει προηγούμενες κλάσεις

    // Χρώμα / animation
    if (type === "success") responseBox.classList.add("msg-success");
    else if (type === "error") responseBox.classList.add("msg-error");
    else responseBox.classList.add("msg-loading");

    responseBox.style.opacity = "1";

    // Εξαφανίζεται μετά από 4 δευτ.
    if (type !== "loading") {
      setTimeout(() => {
        responseBox.style.opacity = "0";
      }, 6000);
    }
  }
});
