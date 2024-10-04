<?php
session_start();

if ($_SESSION["tillåtelse"] === true) {
} else {
    header("Location: ovn_cok3_inloggning.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemligheter</title>
</head>

<body>
    Per är här.

    <form action="" method="post">
        <input type="hidden" name="logout" value="true">
        <input type="hidden" name="destroy" value="true">
        <button type="submit">Logga ut</button>
    </form>

    <?php
    if (isset($_POST["logout"])) {
        // Tar bort hela sessionen och rensar allt
        if (isset($_POST['destroy'])) {
            // Unset all of the session variables.
            $_SESSION = array();

            // From http://php.net/manual/en/function.session-destroy.php
            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            // Finally, destroy the session.
            session_destroy();
        }

        header('Refresh:0');
    }
    ?>
</body>

</html>