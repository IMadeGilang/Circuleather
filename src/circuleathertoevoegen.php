<?php
    // if(isset($_POST['registration'])){
    //     header("Location: eindopdrachtinlog.php"); 
    //     exit();
    // }
    $conn = require_once "partials/dbconnectioncirculeather.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $soorten_Leer = htmlspecialchars(trim($_POST["soorten_Leer"]));
        $bruikbaarheid = htmlspecialchars(trim($_POST["bruikbaarheid"]));
        $gewicht = htmlspecialchars(trim($_POST["gewicht"]));
        $length = htmlspecialchars(trim($_POST["length"]));
        $width = htmlspecialchars(trim($_POST["width"]));
        $kleur = htmlspecialchars(trim($_POST["kleur"]));
        $prijs = htmlspecialchars(trim($_POST["prijs"]));
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

        $stmt = $conn->prepare("INSERT INTO VoorraadLeer (SoortenLeer, Bruikbaarheid, Gewicht, Length, Width, Kleur, Prijs, ManiervanLooien, Category) 
                                VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssddsdss", $soorten_Leer, $bruikbaarheid, $gewicht, $length, $width, $kleur, $prijs, $manier_van_looien, $category);
        $stmt->execute();
        $stmt->close();
        header("Location: circuleathervoorraad.php");
        exit;

        echo"you are now registered";
    }
    mysqli_close($conn);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>circuleather toevoegen page</title>
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
        <label for="kleur" >kleur</label><br>
        <input type="text" id="kleur" name="kleur" value="" required><br>
        <label for="prijs" >prijs</label><br>
        <input type="text" id="prijs" name="prijs" value="" required><br>
        <label for="manier_van_looien" >manier_van_looien</label><br>
        <input type="text" id="manier_van_looien" name="manier_van_looien" value="" required><br>
        <input type="submit" name="register" value="register">
        <a href="eindopdrachtinlog.php">login page</a>
    </form>
</body>
</html>

<?php 
    // source phpregispagina.php
?>


