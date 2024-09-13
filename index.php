<?php
include("incl/config.php");
$title = "Webbserv1 :Start";
$pageId = "start";
$pageStyle = '
figure { 
 border-radius: 10px;
 border-color:#333;
 box-shadow: 10px 10px 5px #888;
}
';
?>
<?php include("incl/header.php"); ?>

<!-- sidans huvudinnehåll  -->
<div id="content">
<article class="justify border">
    <h1>Start</h1>
    <figure class="right top">
        <img src="img/jagohelge.jpg" alt="Per o helge">
        <figcaption>
            <p>Per med kompisen Helge</p>
        </figcaption>
    </figure>
    <p>Hej och välkommen till Per's samlingssida i kursen 
    webbserverprogrammering 1.        
    </p>

</article>
</div>

<?php include("incl/footer.php"); ?>