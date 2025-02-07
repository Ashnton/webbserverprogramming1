<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title>Sök person</title>
</head>

<body>
    <h1>Sök elever</h1>
    <form method="get">
        Namn: <input type="text" onkeyup="showPossibleNames(this.value)">
        <button type="submit">Visa detaljer</button>
    </form>
    <p>Möjliga namn: <strong>
            <span id="possibleNames"></span>
        </strong></p>
    <script>
        async function showPossibleNames(str) {
            if (str.length == 0) {
                document.getElementById("possibleNames").innerHTML = "";
            } else {
                let myObject = await fetch("lookupnames.php?name=" + str);
                let myText = await myObject.text();

                document.getElementById("possibleNames").innerHTML = myText;
            }
        }
    </script>
</body>

</html>