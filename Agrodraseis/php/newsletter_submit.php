<?php
// ============================================
// newsletter_submit.php
// Εγγραφή στο Brevo + email επιβεβαίωσης
// ============================================

// === PHPMailer imports ΠΑΝΩ ΠΑΝΩ (πριν από οτιδήποτε άλλο) ===
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// === Ενεργοποίηση σφαλμάτων για δοκιμές ===
ini_set('display_errors', 1);
error_reporting(E_ALL);

// === Ρυθμίσεις Brevo ===
$apiKey = '....'; // 🔹 βάλε εδώ το δικό σου Brevo API key
$listId = 5; // 🔹 Το ID της λίστας σου

$email = trim($_POST['email'] ?? '');
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Παρακαλώ εισάγετε ένα έγκυρο email.";
    exit;
}

// === Εγγραφή στο Brevo ===
$url = "https://api.brevo.com/v3/contacts";

$data = [
    "email" => $email,
    "listIds" => [$listId],
    "updateEnabled" => true
];

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/json\r\n" .
                     "api-key: $apiKey\r\n",
        "content" => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$httpCode = 0;

if (isset($http_response_header[0])) {
    preg_match('/\d{3}/', $http_response_header[0], $matches);
    $httpCode = (int)($matches[0] ?? 0);
}

// === Έλεγχος αποτελέσματος ===
// === Αποστολή email επιβεβαίωσης ===
try {
    // Δημιουργία νέου αντικειμένου PHPMailer
    $mail = new PHPMailer(true);

    // Ρυθμίσεις SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'harrisstef8@gmail.com'; // ✉️ βάλε εδώ το email σου
    $mail->Password   = '....';   // 🔑 Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8'; // ✅ Διορθώνει τα ελληνικά και το charset

    // Παραλήπτης
    $mail->setFrom('harrisstef8@gmail.com', 'AgroΔράσεις');
    $mail->addAddress($email);

    // Περιεχόμενο email
    $mail->isHTML(true);
    $mail->Subject = "Επιτυχής Εγγραφή στο Newsletter AgroΔράσεις!";
    $mail->Body = "
        <h2>Σας ευχαριστούμε για την εγγραφή σας!</h2>
        <p>Η εγγραφή σας στο newsletter <strong>AgroΔράσεις</strong> ολοκληρώθηκε επιτυχώς.</p>
        <p>Θα λαμβάνετε ενημερώσεις για νέα προγράμματα, δράσεις και διάφορα άλλα.</p>
        <br>
        <p>Με εκτίμηση,<br>Η Ομάδα AgroΔράσεις 🌿</p>
    ";

    $mail->send();
} catch (Exception $e) {
    error_log("Σφάλμα αποστολής email: " . $mail->ErrorInfo);
}

if ($httpCode === 201) {
    echo "✅ Εγγραφήκατε επιτυχώς στο newsletter μας!";
} elseif ($httpCode === 204 || str_contains($response, 'duplicate_parameter')) {
    echo "ℹ️ Είστε ήδη εγγεγραμμένος στο newsletter μας!";
} else {
    echo "❌ Σφάλμα κατά την εγγραφή. Κωδικός: $httpCode";
}


?>
