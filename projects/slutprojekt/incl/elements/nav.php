<nav>
    <div class="navbar">
        <div class="logo"><a href="#">INTE FOODORA</a></div>
        <ul class="menu">
            <li><a href="dashboard.php">Restauranger</a></li>
            <?php if (!isset($_SESSION["restaurant_id"])) {
            ?>
                <li><a href="orders.php">Ordrar</a></li>
            <?php
            } ?>
            <li><a href="../endpoints/logout.php">Logga ut</a></li>
        </ul>
    </div>
</nav>