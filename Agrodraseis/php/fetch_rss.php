<?php
header("Content-Type: application/xml; charset=utf-8");
$xmlUrl = "https://www.ypaithros.gr/feed/"; // Βάλε το RSS feed που χρησιμοποιείς στο articles.php
echo file_get_contents($xmlUrl);
?>
