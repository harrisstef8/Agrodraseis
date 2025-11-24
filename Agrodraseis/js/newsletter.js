document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("newsletterForm");
  const messageBox = document.getElementById("newsletterMessage");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    showMessage("⏳ Παρακαλώ περιμένετε...", "loading");

    try {
      const res = await fetch("php/newsletter_submit.php", {
        method: "POST",
        body: formData
      });
      const text = await res.text();

      if (text.trim() === "OK") {
        showMessage("✅ Εγγραφήκατε επιτυχώς στο newsletter μας!", "success");
        form.reset();
      } else {
        showMessage(text, "error");
      }
    } catch (err) {
      showMessage("❌ Παρουσιάστηκε σφάλμα, προσπαθήστε ξανά.", "error");
    }
  });

  function showMessage(msg, type) {
    messageBox.textContent = msg;
    messageBox.className = type === "success" ? "msg-success" : "msg-error";
    messageBox.style.opacity = "1";

    // Εξαφανίζεται μετά από 6 δευτερόλεπτα
    setTimeout(() => {
      messageBox.style.opacity = "0";
    }, 6000);
  }
});
