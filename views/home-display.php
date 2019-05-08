<?php
$title = "PNL - Article";

ob_start(); ?>
<section class="welcome">
  <h1>Bienvenue au blog du PNL (Parti National Libéral)</h1>
  <h2>Liberté individuelle, égalité économique, fraternité raciale.</h2>
  <img src="http://www.conspiracywatch.info/wp-content/uploads/2017/07/Avec-H.-de-Lesquen.png" alt="Henry de Lesquin">
</section>
<section id="lastPosts">
  <h2>Derniers posts du blog :</h2>
  <?php
  while ($data = $posts->fetch()) {
  ?>
    <a href="index.php?action=article&article=<?= htmlspecialchars($data['id']) ?>">
      <div class="news">
        <h3>
          <?= htmlspecialchars($data['title']) ?>
          <em>le <?= htmlspecialchars($data['creation_date_fr']) ?></em>
        </h3>
        <p>
          <?= htmlspecialchars($data['content']) ?> <br/>
          <em>Article écrit par <?= htmlspecialchars($data['author']) ?></em>
        </p>
      </div>
    </a>

  <?php }
  $posts->closeCursor();?>
</section>

<?php $content = ob_get_clean();

require('template.php');
