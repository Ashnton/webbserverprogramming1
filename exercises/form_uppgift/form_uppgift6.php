<?php
// show all error reporting
error_reporting(-1); // Report all type of errors
ini_set('display_errors', 1); // Display all errors 
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

session_start();

$_SESSION["permission"] = $_SESSION["permission"] ?? false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uppgift 6</title>

    <style>
        .flex {
            display: flex;
            align-items: center;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }
    </style>
</head>

<body>
    <form action="" method="post">

        <?php
        if ($_SESSION["permission"]) {
            if (!isset($_SESSION["curr_q"])) {
                $_SESSION["curr_q"] = 0;
            }
            $curr_q = $_SESSION["curr_q"];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (!empty($_POST['q' . $_SESSION["curr_q"]])) {
                    $_SESSION["curr_q"]++;
                } else if ($curr_q > 3) {
                    $_SESSION['curr_q']++;
                }

                $curr_q = $_SESSION["curr_q"];

                if ($curr_q === 5) {
                    $namn = $_POST["name"];
                    $correct_answers = $_POST["correct-answers"];
                    $content = "Hej $namn! Du fick $correct_answers korrekta svar.";
                    $mejlhuvud = "MIME-Version: 1.0\r\n";
                    $mejlhuvud .= "Content-type: text/html; charset=utf-8\r\n";
                    $mejlhuvud .= "From: perbd@vgy.se \nReply-To: kalle@anka.se";
                    mail($_POST["email"], "Ditt resultat", $content, $mejlhuvud);
                }

                if ($_SESSION["curr_q"] > 4) {
                    $_SESSION["curr_q"] = 0;
                    $_POST = [];
                }

                if ($curr_q === 4) {
        ?>

                    Ditt namn är <?php echo $_POST["q0"]; ?>.

                    <?php
                    if (isset($_POST["q0"]) && isset($_POST["q1"]) && isset($_POST["q2"]) && isset($_POST["q3"])) {
                        $correct_answers = 0;
                        if ($_POST["q1"] == '517') {
                            $correct_answers++;
                        }
                        if ($_POST["q2"] == 'Ja') {
                            $correct_answers++;
                        }
                        if ($_POST["q3"] == 'Kanske') {
                            $correct_answers++;
                        }


                    ?>

                        <fieldset>
                            <legend>Frågor</legend>

                            <div class="flex">
                                <?php if ($_POST["q1"] == '517') {
                                ?>
                                    <label for="q1">Hur mycket väger Helge? (<span class="green" id="a1"><?php echo $_POST["q1"]; ?></span> kg)</label>
                                    <input type="range" name="q1" id="q1" min="100" max="999" required value="<?php echo $_POST["q1"]; ?>">
                                <?php
                                } else {
                                ?>
                                    <label for="q1">Hur mycket väger Helge? (<span class="red" id="a1"><?php echo $_POST["q1"]; ?></span> kg)</label>
                                    <input type="range" name="q1" id="q1" min="100" max="999" required value="<?php echo $_POST["q1"]; ?>">
                                <?php
                                } ?>
                            </div>

                            <?php
                            $svarsalternativ = ["Ja", "Nej", "Kanske", "Jag vet inte"];
                            ?>

                            <div>
                                Är Helge en älg?
                                <div>
                                    <?php
                                    foreach ($svarsalternativ as $alternativ) {
                                        if ($alternativ == $_POST["q2"] && $alternativ == "Ja") {
                                    ?>
                                            <span class="green">
                                                <input type="radio" name="q2" id="q2:1" value="<?php echo $alternativ; ?>">
                                                <label for="q2:1"><?php echo $alternativ; ?></label>
                                            </span>
                                        <?php
                                        } else if ($alternativ == $_POST["q2"]) {
                                        ?>
                                            <span class="red">
                                                <input type="radio" name="q2" id="q2:1" value="<?php echo $alternativ; ?>">
                                                <label for="q2:1"><?php echo $alternativ; ?></label>
                                            </span>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" name="q2" id="q2:1" value="<?php echo $alternativ; ?>">
                                            <label for="q2:1"><?php echo $alternativ; ?></label>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div>
                                Är Per en helg?
                                <div>
                                    <?php
                                    foreach ($svarsalternativ as $alternativ) {
                                        if ($alternativ == $_POST["q3"] && $alternativ == "Kanske") {
                                    ?>
                                            <span class="green">
                                                <input type="radio" name="q3" id="q3:1" value="<?php echo $alternativ; ?>">
                                                <label for="q3:1"><?php echo $alternativ; ?></label>
                                            </span>
                                        <?php
                                        } else if ($alternativ == $_POST["q3"]) {
                                        ?>
                                            <span class="red">
                                                <input type="radio" name="q3" id="q3:1" value="<?php echo $alternativ; ?>">
                                                <label for="q3:1"><?php echo $alternativ; ?></label>
                                            </span>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="radio" name="q3" id="q3:1" value="<?php echo $alternativ; ?>">
                                            <label for="q3:1"><?php echo $alternativ; ?></label>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </fieldset>


                        <?php
                        ?>
                        Du fick <?php echo $correct_answers; ?> rätt.
                        <div>
                            <label for="email">E-postadress</label>
                            <input type="email" name="email" id="email">
                            <input type="hidden" name="correct-answers" id="correct-answers" value="<?php echo $correct_answers; ?>">
                            <input type="hidden" name="name" id="name" value="<?php echo $_POST["q0"]; ?>">
                        </div>
            <?php
                    }
                }
            }

            $curr_q = $_SESSION["curr_q"];
            ?>

            <input type="hidden" value="<?php echo $_POST["curr_q"] ?? 0; ?>" name="curr_q">

            <?php
            if ($curr_q === 0) {
            ?>

                <label for="name">Namn:</label>
                <input type="text" id="q0" name="q0" required>

            <?php
            } else {
            ?>

                <input type="hidden" name="q0" id="q0" value="<?php echo $_POST["q0"] ?? ""; ?>">

            <?php
            }

            if ($curr_q > 0 && $curr_q < 4) {
            ?>
                <fieldset>
                    <legend>Frågor</legend>

                <?php
            }
                ?>



                <?php

                if ($curr_q === 1) {
                ?>

                    <div class="flex">
                        <label for="q1">Hur mycket väger Helge? (<span id="a1"></span> kg)</label>
                        <input type="range" name="q1" id="q1" min="100" max="999" required>
                    </div>

                <?php
                } else {
                ?>

                    <input type="hidden" value="<?php echo $_POST["q1"] ?? 100; ?>" name="q1" id="q1">

                <?php
                }

                if ($curr_q === 2) {
                ?>

                    <div>
                        Är Helge en älg?
                        <div>
                            <input type="radio" name="q2" id="q2:1" value="Ja" required>
                            <label for="q2:1">Ja</label>
                            <input type="radio" name="q2" id="q2:2" value="Nej">
                            <label for="q2:2">Nej</label>
                            <input type="radio" name="q2" id="q2:3" value="Kanske">
                            <label for="q2:3">Kanske</label>
                            <input type="radio" name="q2" id="q2:4" value="Jag vet inte">
                            <label for="q2:4">Jag vet inte</label>
                        </div>
                    </div>

                <?php
                } else {
                ?>

                    <input type="hidden" name="q2" id="q2" value="<?php echo $_POST["q2"] ?? ""; ?>">

                <?php
                }

                if ($curr_q === 3) {
                ?>

                    <div>
                        Är Per en helg?
                        <div>
                            <input type="radio" name="q3" id="q3:1" value="Ja" required>
                            <label for="q3:1">Ja</label>
                            <input type="radio" name="q3" id="q3:2" value="Nej">
                            <label for="q3:2">Nej</label>
                            <input type="radio" name="q3" id="q3:3" value="Kanske">
                            <label for="q3:3">Kanske</label>
                            <input type="radio" name="q3" id="q3:4" value="Jag vet inte">
                            <label for="q3:4">Jag vet inte</label>
                        </div>
                    </div>

                <?php
                } else {
                ?>

                    <input type="hidden" name="q3" id="q3" value="<?php echo $_POST["q3"] ?? ""; ?>">

                <?php
                }

                if ($curr_q > 0 && $curr_q < 4) {
                ?>
                </fieldset>
            <?php
                }
            ?>



            <?php
            if ($curr_q < 3) {
            ?>

                <button type="submit">Nästa fråga</button>

            <?php
            } else if ($curr_q === 4) {
            ?>

                <button type="submit">Nollställ</button>

            <?php
            } else {
            ?>

                <button type="submit">Skicka svar</button>

            <?php
            }
        } else if (!empty($_POST["password"])) {
            if (password_verify($_POST["password"], '$2y$10$FUnyKcPyEKHABYTBdJl7QeKNtS8JgqbjM4wHT38kyT1WYNy90KbmS')) {
                $_SESSION["permission"] = true;
                header("Refresh:0");
            }
        } else {
            ?>
            <label for="password">Lösenord</label>
            <input type="password" name="password" id="password">

            <button type="submit">Skicka</button>
        <?php
        }
        ?>

    </form>

    <script>
        const q1 = document.getElementById('q1');
        const a1 = document.getElementById('a1');
        q1.addEventListener('input', () => {
            updateAnswerDisplay();
        });

        updateAnswerDisplay()

        function updateAnswerDisplay() {
            a1.innerText = q1.value;
        }
    </script>

</body>

</html>