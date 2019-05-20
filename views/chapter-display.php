<?php
$title = 'Chapitre ' . htmlspecialchars($chapter['chapter_number']);

ob_start();?>
<div class="news container">
  <h3><?= 'Chapitre ' . htmlspecialchars($chapter['chapter_number']) . ' : ' . htmlspecialchars($chapter['title']) ?></h3>
  <h6><em>le <?= htmlspecialchars($chapter['publication_date_fr']) ?></em></h6>
  <p>
    <?= $content ?> <br/>
  </p>
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
    <div class="comment">
      <p>
        <strong><?= htmlspecialchars($data['author']) ?></strong>
        <em>le <?= htmlspecialchars($data['creation_date_fr']) ?></em>
        <?php
        if (isset($_SESSION['auth'])) {
          if ($_SESSION["auth"] == "admin" || $_SESSION["pseudo"] == $data['author']) {
            echo "<a href='index.php?action=deletecomment'>Supprimer ce commentaire</a>";
          } else {
            echo "<a href='index.php?action=flag'>Signaler ce commentaire</a>";
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
