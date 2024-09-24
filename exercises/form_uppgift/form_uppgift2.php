<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uppgift 1</title>

    <style>
        .flex {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="name">Namn:</label>
        <input type="text" id="name" name="name" required>

        <fieldset>
            <legend>Frågor</legend>
            
            <div class="flex">
                <label for="q1">Hur mycket väger Helge? (<span id="a1"></span> kg)</label>
                <input type="range" name="q1" id="q1" min="100" max="999" required>
            </div>

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
        </fieldset>

        <button type="submit">Skicka</button>
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

    <?php

        if (isset($_POST["name"]) && isset($_POST["q1"]) && isset($_POST["q2"]) && isset($_POST["q3"])) {
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

            echo "Du heter " . $_POST['name'] . " och fick $correct_answers rätt.";
        }

    ?>

</body>
</html>