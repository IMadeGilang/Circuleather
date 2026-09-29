<?php
    $conn = require_once "partials/dbconnectioncirculeather.php";

        $stmt = $conn->prepare("SELECT COUNT(*) as aantal from VoorraadLeer where category = 'A'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rowA = $result->fetch_assoc(); 

        $stmt = $conn->prepare("SELECT SUM(gewicht) as aantalkg from VoorraadLeer where category = 'A'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rowAkg = $result->fetch_assoc(); 

        $stmt = $conn->prepare("SELECT COUNT(*) as aantal from VoorraadLeer where category = 'B'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rowB = $result->fetch_assoc(); 

        $stmt = $conn->prepare("SELECT SUM(gewicht) as aantalkg from VoorraadLeer where category = 'B'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rowBkg = $result->fetch_assoc();

        $stmt = $conn->prepare("SELECT COUNT(*) as aantal from VoorraadLeer where category = 'C'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rowC = $result->fetch_assoc(); 

        $stmt = $conn->prepare("SELECT SUM(gewicht) as aantalkg from VoorraadLeer where category = 'C'");
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


        //echo "<a href="circuleathertoevoegen.php">Nieuwe Product Toevoegen</a>";
        echo "<a href='circuleathertoevoegen.php'>Nieuwe Product Toevoegen</a>";

        $stmt->close();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voorraad page per category</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <!-- <input type="submit" name="logout" value="logout"> -->
    </form>
</body>
</html>

<?php
// source testoverview.php
// now make a sql for showing the aantaal
?>