<?php
// Start or resume the session
session_start();

$host = "localhost";
$dbusername = "root"; //true for MAMP
$dbpassword = "root"; //true for MAMP
$dbname = "lab3_database";
$dbport = 8889;
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $dbport);
if (mysqli_connect_error()) {
    die('Connect Error(' . mysqli_connect_error() . ')');
} else {
    if (isset($_SESSION['username'])) {
        $selectQuery = "SELECT count FROM users WHERE username = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (isset($_GET['clicked'])) {
            $updateSql = "UPDATE users SET count = count + 1 WHERE username = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param('s', $_SESSION['username']);
            $stmt->execute();        

            $countUpdate = $row['count'] + 1;
            echo "Count: " . $countUpdate . "<br>";
        } else {
            echo "Count: " . $row['count'] . "<br>";
        }
    } else {
        echo "You are not logged in. Please log in.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Button Click Example</title>
    </head>
    <body>
        <a href="?clicked=true"><button>Click Me!!!</button></a>
        <br><a href='login_page.html'><button type='button'>Log Out</button></a>
    </body>
</html>