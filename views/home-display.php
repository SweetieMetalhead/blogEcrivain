<?php
$title = "Billet simple pour l'Alaska";

ob_start(); ?>

<h1>Un aller simple pour l'Alaska</h1>

<?php $content = ob_get_clean();

require('template.php');
