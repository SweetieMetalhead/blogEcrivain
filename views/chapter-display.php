<?php
$title = 'Chapitre ' . htmlspecialchars($chapter['chapter_number']);

ob_start();?>
<div class="news container">
  <h3>
    <?= 'Chapitre ' . htmlspecialchars($chapter['chapter_number']) . ' : ' . htmlspecialchars($chapter['title']) ?>
    <?php if ($userInfo['authorization'] == "author") { ?>
      <a href="#deletechapter" class="btn-floating waves-effect waves-light red right tooltipped modal-trigger" data-tooltip="Supprimer le chapitre"><i class="material-icons">delete</i></a>
      <a href="index.php?action=writechapter&edit=<?= htmlspecialchars($chapter['id']) ?>" class="btn-floating waves-effect waves-light blue right tooltipped" data-tooltip="Modifier le chapitre"><i class="material-icons">edit</i></a>
    <?php } ?>
  </h3>

  <!-- Modal Structure -->
  <div id="deletechapter" class="modal">
    <div class="modal-content">
      <h4>Attention</h4>
      <p>Êtes-vous sûr de vouloir supprimer ce chapitre ?</p>
      <p>Cette action est définitive.</p>
    </div>
    <div class="modal-footer">
      <a href="index.php?action=deletechapter&chapterid=<?= htmlspecialchars($chapter['id']) ?>" class="modal-close waves-effect btn red">Supprimer</a>
      <a href="" class="modal-close waves-effect transparent black-text btn-flat">Annuler</a>
    </div>
  </div>

  <h6><em>le <?= htmlspecialchars($chapter['publication_date_fr']) ?></em></h6>
  <p id="content">
    <?= $content ?>
  </p>

  <div class="center">
    <a class="<?php if($chapter['chapter_number'] <= 1) { echo 'disabled'; } ?> btn" href="index.php?action=chapter&chapternumber=<?= $chapter['chapter_number'] - 1 ?>">Chapitre précédent</a>
    <a class="<?php if($chapter['chapter_number'] >= $numberOfChapters) { echo 'disabled'; } ?> btn" href="index.php?action=chapter&chapternumber=<?= $chapter['chapter_number'] + 1 ?>">Chapitre suivant</a>
  </div>
</div>

<hr>

<div class="container">
  <h2>Commentaires</h2>

  <?php if (!isset($_SESSION['pseudo'])) {
    echo "
    <p>Pour commenter, veuillez vous <a href='index.php?action=login-page'>connecter</a> ou <a href='index.php?action=signin-page'>créer un compte</a>.</p>
    ";
  } else {
    echo "
    <form action='index.php?action=addComment&amp;id=" . $chapter['id'] . "' method='post'>
        <div>
            <label for='comment'>Commentaire</label><br />
            <textarea id='comment' name='comment' required></textarea>
        </div>
        <div>
            <input type='submit' />
        </div>
    </form>
  ";
  }?>

  <?php
  while ($data = $comments->fetch()) {
  ?>
    <div class="comment" id="<?= $data['commentID'] ?>">
      <p>
        <strong><?= htmlspecialchars($data['author']) ?></strong>
        <em>le <?= htmlspecialchars($data['creation_date_fr']) ?></em>
        <?php
        if (isset($_SESSION['pseudo'])) {
          $userManager = new PaulOhl\Blog\Model\UserManager();
          $userInfo = $userManager->getInfo($_SESSION['pseudo']);
          if ($userInfo["authorization"] == "admin" || $userInfo["authorization"] == "author" || $_SESSION["pseudo"] == $data['author']) {
            echo "<a href='index.php?action=deletecomment&comment=" . $data['commentID'] . "'>Supprimer ce commentaire</a>";
          } else {
            echo "<a href='index.php?action=flag&comment=" . $data['commentID'] . "'>Signaler ce commentaire</a>";
          }
        }
       ?>
      <br/>
      <?= htmlspecialchars($data['content']) ?> <br/></p>
    </div>
  <?php }
  $comments->closeCursor(); ?>
</div>

<?php
$content = ob_get_clean();

require('template.php');
