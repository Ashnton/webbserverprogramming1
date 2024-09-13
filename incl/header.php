<!doctype html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style/stylesheet.css"
        title="General stylesheet">
    <link rel="shortcut icon" href="img/favicon_pb.png">

    <!-- Each page can set $pageStyle to create additional style -->
    <?php if (isset($pageStyle)) { ?>
        <style>
            <?php echo $pageStyle; ?>
        </style>
    <?php } ?>
</head>

<!-- The body id helps with highlighting current menu choice -->
<body <?php if (isset($pageId)) echo " id='$pageId' "; ?>>



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