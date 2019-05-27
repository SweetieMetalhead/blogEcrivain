<?php
$title = "Aller simple pour l'Alaska - Votre compte";

ob_start(); ?>

<div class="container">
  <h2>Votre compte :</h2>

  <h3> <?= $userInfo['pseudo'] ?> </h3>

  <p>email : <?= $userInfo['email'] ?></p>
</div>

<hr>

<?php if ($userInfo['pseudo'] == $_SESSION['pseudo']) { ?>
<ul class="collapsible">
  <!-- Account info Change section -->
  <li>
    <div class="collapsible-header">
      <i class="material-icons">edit</i> Changez vos informations
    </div>
    <div class="collapsible-body row white">
      <form id="changepseudo" action="index.php?action=changepseudo" method="post" class="white">
        <div class="input-field col s12 m9">
          <i class="material-icons prefix hide-on-small-only">person</i>
          <input type="text" name="newpseudo" id="newpseudo" required>
          <label for="newpseudo" id="pseudoadvice" class="warning">Changer de pseudo : </label>
        </div>
        <div class="input-field center col s12 m3">
          <input type="submit" name="submit" class="btn" value="Changer">
        </div>
      </form>

      <form id="changeemail" action="index.php?action=changeemail" method="post" class="white">
        <div class="input-field col s12 m9">
          <i class="material-icons prefix hide-on-small-only">email</i>
          <input type="email" name="newemail" id="newemail" required>
          <label for="newemail" id="emailadvice" class="warning">Changer d'adresse email : </label>
        </div>
        <div class="input-field center col s12 m3">
          <input type="submit" name="submit" class="btn" value="Changer">
        </div>
      </form>

      <form id="changepassword" action="index.php?action=changepassword" method="post" class="white">
        <div class="input-field col s12">
          <i class="material-icons prefix hide-on-small-only">lock</i>
          <input type="password" name="oldpassword" id="oldpassword" required>
          <label for="oldpassword" id="oldpasswordadvice" class="warning">Entrez votre ancien mot de passe</label>
        </div>
        <div class="input-field col s12">
          <i class="material-icons prefix hide-on-small-only">lock</i>
          <input type="password" name="newpassword" id="newpassword" required>
          <label for="newpassword" id="newpasswordadvice" class="warning">Entrez votre nouveau mot de passe</label>
        </div>
        <div class="input-field col s12">
          <i class="material-icons prefix hide-on-small-only">lock</i>
          <input type="password" name="passwordconfirm" id="passwordconfirm" required>
          <label for="passwordconfirm" id="confirmationadvice" class="warning">Confirmez votre nouveau mot de passe</label>
        </div>
        <div class="input-field col s12">
          <input type="submit" name="submit" class="btn" value="Changer votre mot de passe">
        </div>
      </form>

      <div class="col s12">
        <a class="btn center" id="accountdelete" href="">Supprimer le compte</a>
      </div>
    </div>

    <script src="public/js/verification.js"></script>
    <script src="public/js/user-manage.js"></script>
  </li>
  <li>
    <?php if (($userInfo['authorization'] == 'admin' || $userInfo['authorization'] == 'author')) {?>
      <div class="collapsible-header">
        <i class="material-icons">chat</i> Signalements de commentaires
        <?php if (countNotifications($_SESSION['pseudo']) > 0): ?>
          <span class="new badge" data-badge-caption="msg"><?= countNotifications($_SESSION['pseudo']); ?></span>
        <?php endif; ?>
      </div>
      <div class="collapsible-body white">
        <table class="highlight">
          <thead>
            <tr>
                <th>Auteur</th>
                <th>Commentaire</th>
                <th>Signalé par</th>
                <th></th>
            </tr>
          </thead>

          <tbody>
            <?php while ($data = $flags->fetch()) {
              $flaggers = $commentManager->getFlagInfo($data['comment_id']);?>
              <tr>
                <td><a href="index.php?action=manage&pseudo=<?= $data['author'] ?>"><?= $data['author'] ?></a></td>
                <td><a href="index.php?action=chapter&chapterid=<?= $data['chapter_number'] . "#" . $data['comment_id'] ?>"><?= $data['comment_sumup'] ?></a></td>
                <td><a class="dropdown-trigger btn" data-target='dropdown<?= $data['comment_id'] ?>'><?= $data['number_of_flaggers'] ?><span class="hide-on-small-only"> personnes</span></a></td>
                <td><a class="btn" href="index.php?action=deleteflags&flaggedcomment=<?= $data['comment_id'] ?>">Ignorer</a></td>
              </tr>
              <!-- Dropdown Structure -->
              <ul id='dropdown<?= $data['comment_id'] ?>' class='dropdown-content'>
                <?php while($flaggersData = $flaggers->fetch()) {
                  $flaggerPseudo = $userManager->getInfo($flaggersData['flagger_id'])['pseudo'];
                  echo "<li><a href='index.php?action=manage&pseudo=" . $flaggerPseudo . "'>" . $flaggerPseudo . "</a></li>";
                } ?>
              </ul>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>
  </li>
  <li>
    <?php if($userInfo['authorization'] == 'author') {?>
      <div class="collapsible-header">
        <i class="material-icons">book</i> Édition de Brouillons
      </div>
      <div class="collapsible-body row white">
        <ul class="collection">
          <?php while ($data = $drafts->fetch()) {
            $content = strip_tags(html_entity_decode($data['content']));?>
            <li class="collection-item avatar">
              <a href="index.php?action=writechapter&edit=<?= $data['id'] ?>">
                <i class="material-icons circle blue">edit</i>
              </a>
              <span class="title">Chapitre <?= $data["chapter_number"] . " : " . $data["title"]; ?></span>
              <p class="grey-text">
                <?php if (strlen($content) <= 200) {
                  echo $content;
                } else {
                  echo substr($content, 0, 200) . "...";
                } ?>
              </p>
              <a href="index.php?action=deletechapter&chapterid=<?= $data['id'] ?>" class="secondary-content">
                <i class="material-icons red-text">delete</i>
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>

    <?php } ?>
  </li>
</ul>
<?php } ?>

<?php
$content = ob_get_clean();

require('template.php');
