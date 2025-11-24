<?php
// ============================================
// contact_submit.php
// Επεξεργασία φόρμας επικοινωνίας για Agrodraseis
// ============================================

// --- Στοιχεία σύνδεσης MySQL ---
$host   = '127.0.0.1';
$user   = 'root';
$pass   = '';
$dbname = 'agrodraseis_db';
$port   = 3307; // ✅ σωστή πόρτα για το δικό σου XAMPP

// Ενεργοποίηση εμφάνισης σφαλμάτων (μόνο για δοκιμή)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Δημιουργία σύνδεσης
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("❌ Σφάλμα σύνδεσης με τη βάση: " . $conn->connect_error);
}

// Επιτρέπουμε μόνο POST αιτήματα
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Παίρνουμε δεδομένα από τη φόρμα
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Βασικός έλεγχος αν είναι συμπληρωμένα
    if (empty($name) || empty($email) || empty($phone) || empty($message) || empty($service)) {
        echo "❌ Παρακαλώ συμπληρώστε όλα τα υποχρεωτικά πεδία.";
        exit;
    }

    // Προετοιμασμένη εντολή (ασφαλής ενάντια σε SQL injection)
    $stmt = $conn->prepare(
        "INSERT INTO messages (name, email, phone, service, message) VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        echo "❌ Σφάλμα προετοιμασίας ερωτήματος: " . $conn->error;
        exit;
    }

    // Σύνδεση τιμών
    $stmt->bind_param("sssss", $name, $email, $phone, $service, $message);

    // Εκτέλεση
    if ($stmt->execute()) {
        echo "✅ Το μήνυμά σας στάλθηκε με επιτυχία! Ευχαριστούμε για την επικοινωνία.";
    } else {
        echo "❌ Σφάλμα κατά την αποστολή: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Δημιουργία αντικειμένου PHPMailer
$mail = new PHPMailer(true);

try {
    // Ρυθμίσεις SMTP (παράδειγμα για Gmail)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'harrisstef8@gmail.com'; // βάλε το email σου εδώ
    $mail->Password   = '....'; // (όχι τον κανονικό Gmail password — χρειάζεται app password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Παραλήπτης   
    $mail->setFrom('harrisstef8@gmail.com', 'AgroΔράσεις');
    $mail->addAddress('harrisstef8@gmail.com', 'AgroΔράσεις'); // ή κάποιο άλλο email προορισμού

    $mail->addReplyTo($email); // για να μπορείς να απαντήσεις απευθείας στον πελάτη
    //$mail->addCC($email); // στέλνει αντίγραφο και στον πελάτη


    // Περιεχόμενο
    $mail->isHTML(true);
    // ✅ Θέμα με το όνομα του πελάτη
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->Subject = "Νέο μήνυμα από τον/την {$name} - AgroΔράσεις ";

    // ✅ Σώμα email με πιο καθαρή εμφάνιση
    $mail->Body = "
        <div style='font-family:Arial,sans-serif; color:#333;'>
            <h2 style='color:#155e2d;'>Νέο μήνυμα μέσω της φόρμας επικοινωνίας</h2>
            <p><strong>Όνομα:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Τηλέφωνο:</strong> {$phone}</p>
            <p><strong>Υπηρεσία:</strong> {$service}</p>
            <hr>
            <p><strong>Μήνυμα:</strong><br>{$message}</p>
            <hr>
            <p style='font-size:13px; color:#777;'>Αυτό το μήνυμα στάλθηκε αυτόματα από τη φόρμα του ιστότοπου AgroΔράσεις.</p>
        </div>
    ";


    $mail->send();

    // ======= Στέλνουμε και email επιβεβαίωσης στον πελάτη =======
$confirm = new PHPMailer(true);
try {
    $confirm->isSMTP();
    $confirm->Host       = 'smtp.gmail.com';
    $confirm->SMTPAuth   = true;
    $confirm->Username   = 'harrisstef8@gmail.com';  // ίδιο email αποστολέα
    $confirm->Password   = '....';    // ίδιο app password
    $confirm->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $confirm->Port       = 587;

    $confirm->setFrom('harrisstef8@gmail.com', 'AgroΔράσεις');
    $confirm->addAddress($email, $name); // 📤 αποστολή στον πελάτη

    $confirm->isHTML(true);
    $confirm->CharSet = 'UTF-8';
    $confirm->Encoding = 'base64';

    $confirm->Subject = "Ευχαριστούμε για την επικοινωνία σας με την AgroΔράσεις!";
    $confirm->Body = "
        <div style='font-family:Arial,sans-serif; color:#333;'>
            <h2 style='color:#155e2d;'>Αγαπητέ/ή {$name},</h2>
            <p>Σας ευχαριστούμε που επικοινωνήσατε μαζί μας σχετικά με την υπηρεσία: <strong>{$service}</strong>.</p>
            <p>Λάβαμε το μήνυμά σας και η ομάδα μας θα επικοινωνήσει μαζί σας το συντομότερο δυνατό.</p>
            <br>
            <p style='color:#155e2d; font-weight:600;'>Με εκτίμηση,<br>Η ομάδα της AgroΔράσεις</p>
            <hr>
            <p style='font-size:12px; color:#777;'>Αυτό είναι ένα αυτοματοποιημένο μήνυμα επιβεβαίωσης — παρακαλούμε μην απαντάτε σε αυτό το email.</p>
        </div>
    ";

    $confirm->send();
} catch (Exception $e) {
    // Δεν χρειάζεται να δείχνουμε σφάλμα στον πελάτη αν αποτύχει η επιβεβαίωση
}

} catch (Exception $e) {
    // Προαιρετικά: μπορείς να κάνεις echo error_log($mail->ErrorInfo);
}


?>

