<?php
    session_start();

   if(!isset($_SESSION['useridonline'])){
      header("Location: circuleatherinlog.php");
      exit();
   }
   $userid = $_SESSION["useridonline"];

   if(isset($_POST['logout'])){
   header("Location: circuleatherlogout.php");
   exit();
   }

    $conn = require_once "partials/dbconnectioncirculeather.php";
    if($userid === 1){
        $stmt = $conn->prepare("SELECT * FROM VoorraadLeer");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0)
            exit('No rows');

        while ($row = $result->fetch_assoc()) {
            echo "voorraad: <br>";
            echo "<table border = 1>";
            echo "<tr>";
            echo "<td>" . "Leer Id" . "</td>";
            echo "<td>" . "Soorten Leer" . "</td>";
            echo "<td>" . "Bruikbaarheid" . "</td>";
            echo "<td>" . "Gewicht" . "</td>";
            echo "<td>" . "Category" . "</td>";
            echo "<td>" . "Length" . "</td>";
            echo "<td>" . "width" . "</td>";
            echo "<td>" . "Kleur" . "</td>";
            echo "<td>" . "Manier van Looien" . "</td>";
            echo "<td>" . "Prijs" . "</td>";
            echo "<td>" . "Delete" . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td> <a href='circuleatherupdate.php?id=" . $row['LeerID'] . "'>" . $row['LeerID'] . "</a></td>";
            echo "<td>" . $row['SoortenLeer'] . "</td>";
            echo "<td>" . $row['Bruikbaarheid'] . "</td>";
            echo "<td>" . $row['Gewicht'] . "</td>";
            echo "<td>" . $row['Category'] . "</td>";
            echo "<td>" . $row['Length'] . "</td>";
            echo "<td>" . $row['Width'] . "</td>";
            echo "<td>" . $row['Kleur'] . "</td>";
            echo "<td>" . $row['ManiervanLooien'] . "</td>";
            echo "<td>" . $row['Prijs'] . "</td>";
            echo "<td> <a href='circuleatherdelete.php?id=" . $row['LeerID'] . "'>" . $row['LeerID'] . "</a></td>";
            echo "</tr>";
            echo "</table>";
            echo "<hr>";
        }
        //echo "<a href="circuleathertoevoegen.php">Nieuwe Product Toevoegen</a>";
        echo "<a href='circuleathertoevoegen.php'>Nieuwe Product Toevoegen</a>" . "<br>";
        echo "<a href='circuleathercategory.php'>Per category</a>" . "<br>";
        echo "<a href='circuleatherbestellingen.php'>Order page</a>";

        $stmt->close();
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>voorraad page</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <input type="submit" name="logout" value="logout">
    </form>
</body>
</html>

<?php
// source testoverview.php
?>