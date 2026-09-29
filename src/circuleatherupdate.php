<?php
    session_start();

    if(!isset($_SESSION['useridonline'])){
      header("Location: circuleatherinlog.php");
      exit();
    }
    $userid = $_SESSION["useridonline"];

    $conn = require_once "partials/dbconnectioncirculeather.php";
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM VoorraadLeer  WHERE LeerID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dbuser = $result->fetch_assoc();
    $stmt->close();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $soorten_Leer = htmlspecialchars(trim($_POST["soorten_Leer"]));
        $bruikbaarheid = htmlspecialchars(trim($_POST["bruikbaarheid"]));
        $gewicht = htmlspecialchars(trim($_POST["gewicht"]));
        $length = htmlspecialchars(trim($_POST["length"]));
        $width = htmlspecialchars(trim($_POST["width"]));
        $kleur = htmlspecialchars(trim($_POST["kleur"]));
        $manier_van_looien = $_POST["manier_van_looien"];

        if($length >= 60 && $width >= 60){
            $category = "C";
        }elseif($length >= 40 && $width >= 40){
            $category = "B";
        }elseif($length >= 23 && $width >= 23){
            $category = "A";
        }elseif($length < 23 && $width < 23){
            $category = "D";
            $bruikbaarheid = "nee";
        }

        $stmt = $conn->prepare("UPDATE VoorraadLeer SET SoortenLeer = ?, Bruikbaarheid = ?, Gewicht = ?, Length = ?, Width = ?, Kleur = ?, ManiervanLooien = ?, Category = ? WHERE LeerID = ?"); 
        $stmt->bind_param("sssddsssi", $soorten_Leer, $bruikbaarheid, $gewicht, $length, $width, $kleur, $manier_van_looien, $category, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: circuleathervoorraad.php");
        exit;

        echo"your data is updated";
    }
    mysqli_close($conn);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>circuleather update page</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="soorten_Leer">soorten_Leer</label><br>
        <input type="text" id="soorten_Leer" name="soorten_Leer" value="" required><br>
        <label for="bruikbaarheid" >bruikbaarheid</label><br>
        <input type="text" id="bruikbaarheid" name="bruikbaarheid" value="" required><br>
        <label for="gewicht" >gewicht</label><br>
        <input type="text" id="gewicht" name="gewicht" value="" required><br>
        <label for="length" >length</label><br>
        <input type="text" id="length" name="length" value="" required><br>
        <label for="width" >width</label><br>
        <input type="text" id="width" name="width" value="" required><br>
        <label for="geslacht" >kleur</label><br>
        <input type="text" id="kleur" name="kleur" value="" required><br>
        <label for="email" >manier_van_looien</label><br>
        <input type="text" id="manier_van_looien" name="manier_van_looien" value="" required><br>
        <input type="submit" name="register" value="update">
        <!-- <a href="eindopdrachtinlog.php">login page</a> -->
    </form>
</body>
</html>

<?php 
    // source phpregispagina.php
?>


