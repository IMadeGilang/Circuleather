<?php 
    session_start();

    $conn = require_once "partials/dbconnectioncirculeather.php";
        
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $_SESSION["usernameLG"] = $_POST["username"];
        $_SESSION["passwordLG"] = $_POST["password"];

        $user = $_SESSION["usernameLG"];
        // $salt = "!@#$%^&*()";
        $pass = $_SESSION["passwordLG"];
        
        $stmt = $conn->prepare("select * from Werker where username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 0){
            exit('No rows');
        }elseif($result->num_rows === 1){
            $dbuser = $result->fetch_assoc();
            if($pass === $dbuser["password"]){
                $_SESSION["useridonline"] = $dbuser["ID"];
                header("Location: circuleathervoorraad.php");
                exit();
            }else{
                echo "username or password is invalid";
            }
        }
        $stmt->close();
    }
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="username">username</label><br>
        <input type="text" id="username" name="username" value=""><br>
        <label for="password" >password</label><br>
        <input type="password" id="password" name="password" value=""><br>
        <input type="submit" name="login" value="login"><br>
        <!-- <input type="submit" name="registration" value="registration"><br> -->
    </form>


</body>
</html>

<?php
    // source phpinlogpagina2.php
?>


