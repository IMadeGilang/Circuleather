<?php
    session_start();

    if(!isset($_SESSION['useridonline'])){
      header("Location: eindopdrachtinlog.php");
      exit();
    }

    $id = $_GET['id'];

    $conn = require_once "partials/dbconnectioncirculeather.php";

        $stmt = $conn->prepare("DELETE from VoorraadLeer WHERE LeerID = ?");
        $stmt->bind_param("i",  $id);
        $stmt->execute();
        $stmt->close();

        header("Location: circuleathervoorraad.php");
        exit;    
    mysqli_close($conn);
?>