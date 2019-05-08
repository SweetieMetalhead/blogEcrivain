<?php
$title = 'Le blog du PNL';

ob_start();?>
<div class="news">
  <h3>
    <?= htmlspecialchars($post['title']) ?>
    <em>le <?= htmlspecialchars($post['creation_date_fr']) ?></em>
  </h3>
  <p>
    <?= htmlspecialchars($post['content']) ?> <br/>
    <em>Article écrit par <?= htmlspecialchars($post['author']) ?></em>
  </p>
</div>
<hr>
<h2>Commentaires</h2>

<?php if (!isset($_SESSION['pseudo'])) {
  echo "
  <p>Pour commenter, veuillez vous <a href='index.php?action=login-page'>connecter</a> ou <a href='index.php?action=signin-page'>créer un compte</a>.</p>
  ";
} else {
  echo "
  <form action='index.php?action=addComment&amp;id=" . $post['id'] . "' method='post'>
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
$comments->closeCursor();

$content = ob_get_clean();

require('template.php');
