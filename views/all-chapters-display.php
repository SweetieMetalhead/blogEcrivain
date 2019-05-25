<?php
$title = 'Tout les chapitres';

ob_start();?>

<?php require('page-selector.php') ?>

<?php while($data = $chapters->fetch()) { ?>
<div class="container">
  <div class="card hoverable">
    <div class="card-content">
      <?php if($data['chapter_number'] == $numberOfChapters) {?><h6 class="grey-text">dernier chapitre paru</h6> <?php } ?>
      <span class="card-title">Chapitre <?= $data['chapter_number'] . " : " . $data['title'] ?></span>
      <p><?= substr(strip_tags(html_entity_decode($data['content'])), 0, 400) ?>...</p>
    </div>
    <div class="card-action row">
      <a href="index.php?action=chapter&chapterid= <?= $data['id'] ?>">Voir le chapitre</a>
    </div>
  </div>
</div>
<?php } ?>

<?php require('page-selector.php') ?>

<?php
$content = ob_get_clean();

require('template.php');
