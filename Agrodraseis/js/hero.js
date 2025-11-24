document.addEventListener("DOMContentLoaded", () => {
  console.log("JS Loaded ✅");

  const line1Text = "Εξειδικευμένες Γεωπονικές";
  const line2Text = "Συμβουλές";
  const subtitleText = "Προσφέρουμε ολοκληρωμένες λύσεις για τη βελτίωση της απόδοσης των καλλιεργειών σας με σύγχρονες μεθόδους και επιστημονική τεκμηρίωση.";

  const line1 = document.getElementById("line1");
  const line2 = document.getElementById("line2");
  const subtitle = document.getElementById("subtitle");
  const heroActions = document.querySelector(".hero-actions");
  const heroNote = document.querySelector(".hero-note");

  if (!line1 || !line2 || !subtitle) {
    console.error("❌ Δεν βρέθηκαν στοιχεία (line1, line2 ή subtitle)");
    return;
  }

  let i = 0, j = 0, k = 0;

  // Γράφει την 1η γραμμή
  function typeLine1() {
    if (i < line1Text.length) {
      line1.textContent += line1Text.charAt(i);
      i++;
      setTimeout(typeLine1, 90);
    } else {
      setTimeout(typeLine2, 600);
    }
  }

  // Γράφει τη 2η γραμμή
  function typeLine2() {
    if (j < line2Text.length) {
      line2.textContent += line2Text.charAt(j);
      j++;
      setTimeout(typeLine2, 90);
    } else {
      setTimeout(showSubtitle, 800);
    }
  }

  // Εμφανίζει τον υπότιτλο με fade (όχι γράψιμο)
  function showSubtitle() {
    subtitle.textContent = subtitleText;
    subtitle.classList.add("fade-in");
    setTimeout(() => {
      heroActions.classList.add("fade-in");
      heroNote.classList.add("fade-in");
      console.log("✨ Fade-in ενεργοποιήθηκε");
    }, 300);
  }

  typeLine1();
});
