<?php
    //to see results -> http://localhost:8888/insert_signup.php
    $host = "localhost";
    $dbusername = "root"; //true for MAMP
    $dbpassword = "root"; //true for MAMP
    $dbname = "lab3_database";
    $dbport = 8889;
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $dbport);
    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_error() . ')');
    } else {
        //check if username not taken; if so, insert it
        //$toInsertUsername = "Elon";
        //$toInsertPassword = "cagematch";
        $toInsertUsername = $_GET["username"];
        $toInsertPassword = $_GET["password"];

        //check username not taken
        $selectQuery = "SELECT username FROM users WHERE username = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $toInsertUsername);
        $stmt->execute();
        $res = $stmt->get_result();
        $numresults = mysqli_num_rows($res);

        if ($numresults > 0) {
            // means $toInsertUsername is already in the table
            echo("Someone already has this username");
            echo "<br><a href='signup_page.html'><button type='button'>Back</button></a>";
        } else {
            // Insert new user/pass
            $insertQuery = "INSERT INTO users (username, password, count) VALUES (?, ?, 1)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $toInsertUsername, $toInsertPassword);
            $stmt->execute();
            echo "New account added successfully";
            echo "<br><a href='login_page.html'><button type='button'>Sign In</button></a>";
        }
        $conn->close();
    }
?>