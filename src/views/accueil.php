<?php ob_start(); ?>



<?php render("default", true, [
  "title" => "Connection",
  "css" => "accueil",
  "js" => "accueil",
  "content" => ob_get_clean(),
]);
?>
