<?php
    //to see results -> http://localhost:8888/enter_signin.php
    session_start();// Start session

    $host = "localhost";
    $dbusername = "root"; //true for MAMP
    $dbpassword = "root"; //true for MAMP
    $dbname = "lab3_database";
    $dbport = 8889;
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $dbport);
    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_error() . ')');
    } else {
        $toInsertUsername = $_GET["username"];
        $toInsertPassword = $_GET["password"];

        //check username not taken
        $selectQuery = "SELECT username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $toInsertUsername);
        $stmt->execute();
        $res = $stmt->get_result();
        $numresults = mysqli_num_rows($res);

        if ($numresults > 0) {
            //check same pw 
            $row = $res->fetch_assoc();
            $storedPassword = $row["password"];
            
            if ($toInsertPassword === $storedPassword) {
                $_SESSION['username'] = $toInsertUsername;//store session
                header("Location: count.php");
            } else {
                echo "Incorrect password, please try again";
                echo "<br><a href='login_page.html'><button type='button'>Back</button></a>";
            }
        } else {
            echo("This account does not exist");
            echo "<br><a href='login_page.html'><button type='button'>Back</button></a>";
        }
        $conn->close();
    }  
?>