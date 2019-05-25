<?php if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
  $pageNumber = $_GET['page'];
} else {
  $pageNumber = 1;
}

$maxPageNumber = ceil($numberOfChapters / 5);
// $maxPageNumber = 7;
?>

<div class="container center selector">
  <a href="index.php?action=allchapters&page=<?= $pageNumber-1 ?>" class="btn waves-effect waves-light <?php if($pageNumber <= 1) { echo "disabled"; } ?>"><i class="material-icons">arrow_back</i></a>
  <?php if ($pageNumber > 2): ?>
    <a href="index.php?action=allchapters&page=1" class="btn waves-effect waves-light">1</a>
  <?php endif; ?>
  <?php if ($pageNumber >= 4): ?>
    <a class="btn waves-effect waves-light">...</a>
  <?php endif; ?>
  <?php if ($pageNumber >= 2): ?>
    <a href="index.php?action=allchapters&page=<?= $pageNumber - 1 ?>" class="btn waves-effect waves-light"><?= $pageNumber - 1 ?></a>
  <?php endif; ?>
  <a class="btn indigo"><?= $pageNumber ?></a>
  <?php if ($pageNumber <= $maxPageNumber - 2): ?>
    <a href="index.php?action=allchapters&page=<?= $pageNumber + 1 ?>" class="btn waves-effect waves-light"><?= $pageNumber + 1 ?></a>
  <?php endif; ?>
  <?php if ($pageNumber <= $maxPageNumber - 3): ?>
    <a class="btn waves-effect waves-light">...</a>
  <?php endif; ?>
  <?php if ($maxPageNumber > 1 && $pageNumber != $maxPageNumber): ?>
    <a href="index.php?action=allchapters&page=<?= $maxPageNumber ?>" class="btn waves-effect waves-light"><?= $maxPageNumber ?></a>
  <?php endif; ?>
  <a href="index.php?action=allchapters&page=<?= $pageNumber+1 ?>" class="btn waves-effect waves-light <?php if($pageNumber == $maxPageNumber) { echo "disabled"; } ?>"><i class="material-icons">arrow_forward</i></a>
</div>
