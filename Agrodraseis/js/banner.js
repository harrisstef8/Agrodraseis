document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    fetch("php/fetch_rss.php")
      .then(response => response.text())
      .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
      .then(data => {
        const firstItem = data.querySelector("item");
        if (firstItem) {
          const title = firstItem.querySelector("title").textContent.trim();

          // βρίσκουμε το <li> που υπάρχει ήδη στο HTML
          const li = document.querySelector("#tipBanner ul li");

          // αντικαθιστούμε μόνο το περιεχόμενο με τον τίτλο του άρθρου
          li.innerHTML = `
            ${title}<br>
            <a href="php/articles.php">Διαβάστε περισσότερα</a>
          `;

          // κάνουμε το banner να εμφανιστεί (αν έχει το .show)
          document.getElementById("tipBanner").classList.add("show");
        } else {
          console.warn("Δεν βρέθηκε άρθρο στο RSS feed.");
        }
      })
      .catch(err => console.error("Σφάλμα φόρτωσης RSS:", err));
  }, 7000); // καθυστέρηση 8 δευτερολέπτων πριν εμφανιστεί
});
// Κλείσιμο banner όταν πατηθεί το Χ
document.addEventListener("DOMContentLoaded", () => {
  const closeBtn = document.getElementById("closeTip");
  const banner = document.getElementById("tipBanner");

  if (closeBtn && banner) {
    closeBtn.addEventListener("click", () => {
      banner.classList.remove("show"); // εξαφανίζει με transition
      setTimeout(() => {
        banner.style.display = "none"; // το κρύβει τελείως μετά το animation
      }, 1000); // όσο το transition της CSS (1s)
    });
  }
});



// document.addEventListener("DOMContentLoaded", () => {
//   setTimeout(() => {
//     fetch("php/fetch_rss.php")
//       .then(response => response.text())
//       .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
//       .then(data => {
//         const firstItem = data.querySelector("item");
//         if (firstItem) {
//           const title = firstItem.querySelector("title")?.textContent.trim() || "Χωρίς τίτλο";
//           const link = firstItem.querySelector("link")?.textContent.trim() || "php/articles.php";

//           // βρίσκουμε το li μέσα στο banner
//           const li = document.querySelector("#tipBanner ul li");

//           // αντικαθιστούμε μόνο το περιεχόμενο με τίτλο + δυναμικό link
//           li.innerHTML = `
//             ${title}<br>
//             <a href="${link}" target="_blank">Διαβάστε περισσότερα</a>
//           `;

//           // εμφανίζουμε το banner
//           document.getElementById("tipBanner").classList.add("show");
//         } else {
//           document.querySelector("#tipBanner ul li").innerHTML = "Δεν βρέθηκαν νέα.";
//         }
//       })
//       .catch(err => console.error("Σφάλμα φόρτωσης RSS:", err));
//   }, 7000);
// });
// Κλείσιμο banner όταν πατηθεί το Χ
// document.addEventListener("DOMContentLoaded", () => {
//   const closeBtn = document.getElementById("closeTip");
//   const banner = document.getElementById("tipBanner");

//   if (closeBtn && banner) {
//     closeBtn.addEventListener("click", () => {
//       banner.classList.remove("show"); // εξαφανίζει με transition
//       setTimeout(() => {
//         banner.style.display = "none"; // το κρύβει τελείως μετά το animation
//       }, 1000); // όσο το transition της CSS (1s)
//     });
//   }
// });
