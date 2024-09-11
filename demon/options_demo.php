<?php
if (isset($_POST["skickafarg"])) {
    print_r($_POST["farger"]);

    // if ( isset($_POST["farger"]) ) {
    //     $meddelande = "<p><strong>Du gillar färgerna ";
    //     $minArray = $_POST["farger"];
    //     foreach ($minArray as $value) {
    //         $meddelande .= $value." ";
    //     }
    //     $meddelande .= "</strong></p>";
    // }
    // echo $meddelande;
} 
?>

<form method="post" action="">
    Mina favoritfärger<br>
    <select name="farger[]" size="5" multiple="multiple">
        <option value="Röd">Röd</option>
        <option value="Svart">Svart</option>
        <option value="Orange">Orange</option>
        <option value="Grön">Grön</option>
        <option value="Gul">Gul</option>
    </select><br>
    <br>
    <input type="submit" name="skickafarg" value="Skicka"><br>
</form>