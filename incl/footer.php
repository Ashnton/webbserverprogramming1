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