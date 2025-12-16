<?php ob_start(); ?>



<script src="../assets/js/index.js"></script>
<?php render("default", true, [
  "title" => "Acceuil",
  "css" => "index",
  "content" => ob_get_clean(),
]);
?>