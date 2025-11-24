// document.addEventListener("DOMContentLoaded", () => {
//   const modal = document.getElementById("serviceModal");
//   const closeBtn = document.querySelector(".close");
//   const modalText = document.getElementById("modalText");

//   document.querySelectorAll(".service-more-btn").forEach((btn, index) => {
//     btn.addEventListener("click", () => {
//       showServiceInfo(index + 1);
//       modal.style.display = "flex"; // για το κεντραρισμένο modal
//     });
//   });

//   closeBtn.onclick = () => (modal.style.display = "none");
//   window.onclick = (e) => {
//     if (e.target === modal) modal.style.display = "none";
//   };

//   function showServiceInfo(id) {
//     const info = {
//       1: `
//         <ul>
//           <li>Ολοκληρωμένη διαχείριση δηλώσεων ΟΣΔΕ</li>
//           <li>Ακρίβεια και συνέπεια στην υποβολή</li>
//           <li>Πλήρης ανάληψη όλων των διαδικασιών</li>
//         </ul>
//       `,
//       2: `
//         <ul>
//           <li>Βιολογική Γεωργία – Κτηνοτροφία</li>
//           <li>Μείωση Νιτρορύπανσης</li>
//           <li>Σύστημα ολοκληρωμένης διαχείρισης</li>
//           <li>Σπάνιες φυλές</li>
//           <li>Πρόγραμμα Πρώτης Δάσωσης Γαιών</li>
//         </ul>
//       `,
//       3: `
//         <ul>
//           <li>Αδειοδότηση σταβλικών εγκαταστάσεων</li>
//           <li>Περιβαλλοντικές μελέτες σταβλικών εγκαταστάσεων</li>
//           <li>Αδειοδότηση νέων γεωτρήσεων – νομιμοποίηση υφιστάμενων γεωτρήσεων</li>
//           <li>Έκδοση και ανανέωση αδειών παραγωγών λαϊκών αγορών – πλανόδιου εμπορίου</li>
//         </ul>
//       `,
//       4: `
//         <ul>
//           <li>Ενημέρωση Κτηνοτροφικών Μητρώων (Αιγοπροβάτων – Βοοειδών)</li>
//           <li>Εγγραφή στο Μητρώο Αγροτών (Μ.Α.Α.Ε.)</li>
//           <li>Συμβουλευτικές υπηρεσίες για Ενιαία Αίτηση Ενίσχυσης (Ο.Σ.Δ.Ε.)</li>
//           <li>Αιτήσεις Αδειών Φύτευσης Αμπελώνων</li>
//           <li>LEADER</li>
//           <li>ISO – HACCP</li>
//           <li>Εγγραφή στο Μητρώο Κ.Η.Μ.Ο. (Οικοτεχνία)</li>
//           <li>Εγγραφή στο Μητρώο Νωπών Αγροτικών Προϊόντων (GR)</li>
//         </ul>
//       `,
//       5: `
//         <ul>
//           <li>Σχέδια βελτίωσης γεωργοκτηνοτροφικών εκμεταλλεύσεων</li>
//           <li>Εγκατάσταση Νέων Αγροτών</li>
//           <li>Εμπορία & μεταποίηση αγροτικών προϊόντων</li>
//           <li>Μελέτη αγοράς αγροτικής γης με επιδοτούμενο δάνειο</li>
//           <li>Πρόγραμμα διασφάλισης ποιότητας τροφίμων</li>
//           <li>Προγράμματα LEADER</li>
//         </ul>
//       `,
//       6: `
//         <ul>
//           <li>Σχέδια βελτίωσης γεωργοκτηνοτροφικών εκμεταλλεύσεων</li>
//           <li>Εγκατάσταση Νέων Αγροτών</li>
//           <li>Εμπορία & μεταποίηση αγροτικών προϊόντων</li>
//           <li>Μελέτη αγοράς αγροτικής γης με επιδοτούμενο δάνειο</li>
//           <li>Πρόγραμμα διασφάλισης ποιότητας τροφίμων</li>
//           <li>Προγράμματα LEADER</li>
//         </ul>
//       `,
//     };
//     modalText.innerHTML =
//       info[id] ||
//       "<p>Δεν υπάρχουν ακόμα πληροφορίες για αυτή την υπηρεσία.</p>";
//   }
// });


document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".tab-btn");
  const contents = document.querySelectorAll(".tab-content");

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      buttons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");

      const target = btn.getAttribute("data-target");
      contents.forEach(content => {
        content.classList.remove("active");
        if (content.id === target) content.classList.add("active");
      });
    });
  });
});
