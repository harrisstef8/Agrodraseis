<?php include "header.php"; ?>
<link rel="stylesheet" href="../css/articles.css">

  <!-- <div class="news-hero">
  <img src="../images/background2.jpg">
  <div class="overlay">
    <h1>Νέα & Ενημερώσεις</h1>
    <p>Τα τελευταία νέα από τον αγροτικό κόσμο</p>
  </div>
</div> -->
<section class="rss-section">
  <h1 class="section-title">Τελευταία Νέα από το Ypaithros.gr</h1>

  <?php
  $rss_url = "https://www.ypaithros.gr/feed/";

  // Προσπαθούμε με timeout για σταθερότητα
  $context = stream_context_create(['http' => ['timeout' => 5], 'https' => ['timeout' => 5]]);
  $rss_data = @file_get_contents($rss_url, false, $context);

  if ($rss_data) {
      $rss = @simplexml_load_string($rss_data);
  } else {
      $rss = false;
  }

  if ($rss && isset($rss->channel->item)) {
      echo "<div class='rss-container'>";
      $count = 0;

      foreach ($rss->channel->item as $item) {
          if ($count >= 6) break;

          $title = (string) $item->title;
          $link  = (string) $item->link;
          $date  = date('d/m/Y', strtotime((string)$item->pubDate));
          $desc  = strip_tags((string)$item->description);
          $image = '';

          // ✅ Πραγματικό κόλπο: ψάχνουμε στο <content:encoded>
          $namespaces = $item->getNamespaces(true);
          if (isset($namespaces['content'])) {
              $content = $item->children($namespaces['content']);
              if (isset($content->encoded)) {
                  $html = (string)$content->encoded;
                  if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $match)) {
                      $image = $match[1];
                  }
              }
          }

          echo "<div class='rss-item'>";
          if ($image) {
              echo "<img src='" . htmlspecialchars($image, ENT_QUOTES) . "' alt='Εικόνα άρθρου'>";
          } else {
              echo "<div class='no-image'></div>";
          }

          echo "<div class='rss-text'>
                  <h3>" . htmlspecialchars($title, ENT_QUOTES) . "</h3>
                  <small>$date</small>
                  <p>" . htmlspecialchars(mb_strimwidth($desc, 0, 200, '...', 'UTF-8')) . "</p>
                  <a href='" . htmlspecialchars($link, ENT_QUOTES) . "' target='_blank' class='more-btn'>Δείτε περισσότερα</a>
                </div>
          </div>";

          $count++;
      }

      echo "</div>";
  } else {
      echo "<p class='rss-error'>⚠️ Δεν ήταν δυνατή η φόρτωση των ειδήσεων αυτή τη στιγμή.</p>";
  }
  ?>
</section>
<script src="../js/scroll.js" defer></script>

<?php include "footer.php"; ?>
