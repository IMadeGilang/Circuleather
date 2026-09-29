<?php
    $conn = require_once "partials/dbconnectioncirculeather.php";

    if (isset($_POST['kopen'])) {
        $category = $_POST['category'];
        $aantal = $_POST['aantal'];
        $klantNaam = $_POST['klantNaam'];

        if ($aantal < 1) {
            echo "insert aantal!";
        }elseif ($klantNaam == "") {
            echo "insert your name!";
        }else{
            $stmt = $conn->prepare("SELECT KlantID FROM Klanten WHERE KlantenNaam = ?");
            $stmt->bind_param("s", $klantNaam);
            $stmt->execute();

            $resultKlant = $stmt->get_result();

            if ($resultKlant->num_rows > 0){
                $rowKlant = $resultKlant->fetch_assoc();
                $klant_id = $rowKlant['KlantID'];
            }

            else {

                $stmt->close();

                $stmt = $conn->prepare(
                    "INSERT INTO Klanten (KlantenNaam)
                     VALUES (?)"
                );

                $stmt->bind_param("s", $klantNaam);

                $stmt->execute();

                $klant_id = $conn->insert_id;
            }

            $stmt->close();


            $stmt = $conn->prepare("SELECT leerID, prijs FROM VoorraadLeer WHERE category = ? AND verkocht = 0 LIMIT ?");
            $stmt->bind_param("si", $category, $aantal);
            $stmt->execute();
            $result = $stmt->get_result();

            $gevonden = $result->num_rows;

            if ($gevonden < $aantal) {
                echo "Niet genoeg voorraad van category " . $category . ".";
            } else {

                while ($row = $result->fetch_assoc()) {

                    $leerID = $row['leerID'];
                    $prijs = $row['prijs'];


                    $stmtBestelling = $conn->prepare(
                        "INSERT INTO Bestellingen
                        (Totaal_prijs, LeerID, KlantID)
                        VALUES (?, ?, ?)"
                    );

                    $stmtBestelling->bind_param(
                        "dii",
                        $prijs,
                        $leerID,
                        $klant_id
                    );

                    $stmtBestelling->execute();

                    $stmtVerkocht = $conn->prepare(
                        "UPDATE VoorraadLeer
                         SET verkocht = 1
                         WHERE leerID = ?"
                    );

                    $stmtVerkocht->bind_param("i", $leerID);

                    $stmtVerkocht->execute();


                    $stmtBestelling->close();
                    $stmtVerkocht->close();
                }
                    echo "<h2>Bestelling geplaatst voor " . $klantNaam . "!</h2>";

            }


            $stmt->close();
        }
    }


    $stmt = $conn->prepare(
        "SELECT COUNT(*) as aantal
         FROM VoorraadLeer
         WHERE category = 'A'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowA = $result->fetch_assoc();


    $stmt = $conn->prepare(
        "SELECT SUM(gewicht) as aantalkg
         FROM VoorraadLeer
         WHERE category = 'A'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowAkg = $result->fetch_assoc();


    $stmt = $conn->prepare(
        "SELECT COUNT(*) as aantal
         FROM VoorraadLeer
         WHERE category = 'B'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowB = $result->fetch_assoc();


    $stmt = $conn->prepare(
        "SELECT SUM(gewicht) as aantalkg
         FROM VoorraadLeer
         WHERE category = 'B'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowBkg = $result->fetch_assoc();



    $stmt = $conn->prepare(
        "SELECT COUNT(*) as aantal
         FROM VoorraadLeer
         WHERE category = 'C'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowC = $result->fetch_assoc();


    $stmt = $conn->prepare(
        "SELECT SUM(gewicht) as aantalkg
         FROM VoorraadLeer
         WHERE category = 'C'
         AND verkocht = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $rowCkg = $result->fetch_assoc();


    echo "voorraad per category: <br>";

    echo "<table>";
    echo "<tr>";
    echo "<td>" . "Aantal" . "</td>";
    echo "<td>" . "Category" . "</td>";
    echo "<td>" . "Length" . "</td>";
    echo "<td>" . "Width" . "</td>";
    echo "<td>" . "Kg" . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $rowA['aantal'] . "</td>";
    echo "<td>" . "A" . "</td>";
    echo "<td>" . "23" . "</td>";
    echo "<td>" . "23" . "</td>";
    echo "<td>" . $rowAkg['aantalkg'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $rowB['aantal'] . "</td>";
    echo "<td>" . "B" . "</td>";
    echo "<td>" . "40" . "</td>";
    echo "<td>" . "40" . "</td>";
    echo "<td>" . $rowBkg['aantalkg'] . "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $rowC['aantal'] . "</td>";
    echo "<td>" . "C" . "</td>";
    echo "<td>" . "60" . "</td>";
    echo "<td>" . "60" . "</td>";
    echo "<td>" . $rowCkg['aantalkg'] . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<hr>";


    echo "Leer kopen";
    echo "<br><br>";
    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";

    echo "<label>Naam:</label>";
    echo "<input type='text' name='klantNaam' required>";
    echo "<br><br>";

    echo "<label>Category:</label>";
    echo "<select name='category'>";
    echo "<option value='A'>A</option>";
    echo "<option value='B'>B</option>";
    echo "<option value='C'>C</option>";
    echo "</select>";
    echo "<br><br>";


    echo "<label>Aantal:</label>";
    echo "<input type='number' name='aantal' min='1' value='1' required>";
    echo "<br><br>";

    echo "<input type='submit' name='kopen' value='Kopen'>";
    echo "</form>";
    echo "<hr>";


    //echo "<a href='circuleathertoevoegen.php'>Nieuwe Product Toevoegen</a>";


    $stmt->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart page</title>

</head>

<body>

</body>

</html>
<?php 
// source testcirculeatherbestellingen.php
?>

