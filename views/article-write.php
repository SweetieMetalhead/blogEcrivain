<?php
$title = 'PNL - écriture d\'article';

ob_start();?>

<h1>Écriture d'article</h1>

//use TinyMCE for the WYSIWYG interface for writing articles

<?php
$content = ob_get_clean();

require('template.php');
