<?php
include("incl/config.php");
$title = "Webbserv1: Övningar";
$pageId = "exercises";
$pageStyle = '
ul#exer {
 list-style-type:none;
}
ul#exer a {
 margin:-40px;
}
';

include("incl/header.php");

$title = "Webbserv1: Övningar";
$pageId = "viewsource";

// Include code from filefinder.php to display navigator
$sourceBasedir = dirname(__FILE__);
$sourceNoEcho = true;
include("filefinder.php");
$pageStyle = $sourceStyle;
?>

<!-- sidans huvudinnehåll  -->
<div id="content">
    <aside>
        <p></p>
        <p></p>

        <!-- Menyn med övningar  -->
        <h3>Mina övningar</h3>
        <!-- <nav>
            <ul id="exer">
                <li id="grunder"><a href="exercises/grunder.php" target="_blank">Grunder 1-7</a></li>
                <li id="funktioner"><a href="exercises/funktioner.php" target="_blank">Funktioner</a></li>
                <li id="formular7"><a href="exercises/formular7.php" target="_blank">Formulär 7</a></li>
                <li id="formquiz3"><a href="exercises/form-quiz-3" target="_blank">Form Quiz 3</a></li>
                <li id="string4"><a href="exercises/string4.php" target="_blank">Textsträng 4</a></li>
            </ul>
        </nav> -->
        <?php echo "$sourceBody"; ?>
        <hr>
    </aside>

    <article class="justify border">

        <!-- Sidans/Dokumentets huvudsakliga innehåll -->
        <h1>Övningar i kursen</h1>

        <p>Här är en samlingssida för mina övningar i de olika kursmomenten.</p>

        <p>Skapa en ny sida varje gång du implementerar en ny övning. Då har du alltid
            ett kodexempel att gå tillbaka till. Du slipper komma ihåg de exakta konstruktionerna. Du har löst
            problemet en gång och du vet var du har lösningen. Perfekt.</p>

        <p>Källkoden till mina övningar och övriga delar till sidan,
            <a href="viewsource.php?dir=exercises">hittar du i denna katalogen</a>.
        </p>

    </article>
</div>

<?php include("incl/footer.php"); ?>