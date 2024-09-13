<?php
include("incl/config.php");

$title = "Webbserv1: Övningar";
$pageId = "viewsource";

// Include code from filefinder.php to display navigator
$sourceBasedir = dirname(__FILE__);
$sourceNoEcho = true;
include("filefinder.php");
$pageStyle = $sourceStyle;
?>


<?php include("incl/header.php"); ?>

<!-- Sidans/Dokumentets huvudsakliga innehåll -->
<div id="content">
    <?php echo "$sourceBody"; ?>
    <hr>
</div>

<?php include("incl/footer.php"); ?>