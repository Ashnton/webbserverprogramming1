<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning formulär 2</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="förnamn" id="förnamn-input">
        <input type="text" name="efternamn" id="efternamn-input">
        <input type="text" name="klass" id="klass-input">

        <select name="maträtter[]" id="maträtter-input" size="7" multiple="multiple">
            <option value="Tacos">Tacos</option>
            <option value="Lasagne">Lasagne</option>
            <option value="Pad thai">Pad thai</option>
            <option value="Pad Kra Pow">Pad Kra Pow</option>
            <option value="Pad Met Mamuang">Pad Met Mamuang</option>
            <option value="Kyckling curry">Kyckling curry</option>
            <option value="Kyckling Tikka Sizzlar">Kyckling Tikka Sizzlar</option>
        </select>

        Vilken är den roligaste kursen?<br>
        <input type="radio" name="kurs" id="Kemi" value="Kemi"><label for="Kemi">Kemi</label>
        <input type="radio" name="kurs" id="Religionskunskap" value="Religionskunskap"><label for="Religionskunskap">Religionskunskap</label>
        <input type="radio" name="kurs" id="Webbserverprogrammering" value="Webbserverprogrammering"><label for="Webbserverprogrammering">Webbserverprogrammering</label>

        <button type="submit">Skicka</button>
    </form>


    <?php 
        if (!empty($_POST["förnamn"])) {
            $matsträng = "";
            foreach ($_POST["maträtter"] as $mat) {$matsträng = $matsträng . $mat . ' ';}; 

            $min_sträng = "Hjärtligt välkommen " . $_POST['förnamn'] . " " . $_POST['efternamn'] . " i " . $_POST["klass"] . ". Du gillar mat " . $matsträng . ". Din favoritkurs är " . $_POST["kurs"];
            echo $min_sträng;
            // mail("antonlm@varmdogymnasium.se", "BFS Formripper Service", $min_sträng);
        }
    ?>
</body>
</html>