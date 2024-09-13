<?php
// show all error reporting
error_reporting(-1); // Report all type of errors
ini_set('display_errors', 1); // Display all errors 
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

// time page generation, display in footer. 
$pageTimeGeneration = microtime(true);

// useful constants
// useful functions

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
<!doctype html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style/stylesheet.css" title="General stylesheet">
    <link rel="shortcut icon" href="img/favicon_pb.png">

    <!-- Each page can set $pageStyle to create additional style -->
    <?php if (isset($pageStyle)) { ?>
        <style>
            <?php echo $pageStyle; ?>
        </style>
    <?php } ?>
</head>

<!-- The body id helps with highlighting current menu choice -->
<body<?php if (isset($pageId)) echo " id='$pageId' "; ?>>



    <!-- header -->
    <header id="top">
        <span class="logga">Webbserverprogrammering 1</span>

        <!-- navigation menu -->
        <nav class="navmenu">
            <a id="start-" href="index.php">Start</a>
            <a id="comments-" href="comments.php">Reflektioner</a>
            <a id="exercises-" href="exercises.php">Övningar</a>
            <a id="viewsource-" href="viewsource.php">Källkod</a>
        </nav>
    </header>

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
            <p>Hej och välkommen till Per's samlingssida i kursen webbserverprogrammering 1.
            </p>

        </article>
    </div>

    <!-- footer -->
    <footer id="bottom">
        <p>Verktyg:
            <a href="http://validator.w3.org/check/referer">HTML5</a>
            <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
            <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>
            <a href="viewsource.php">Källkod</a>
        </p>

        <?php if (isset($pageTimeGeneration)) { ?>
            <p>Sidan skapades på <?php echo round(microtime(true) - $pageTimeGeneration, 5); ?> sekunder</p>
        <?php } ?>
    </footer>
    </body>

</html>