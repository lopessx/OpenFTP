<?php 
    session_start();
    include 'db.inc.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $filter = [
        'username' => $username, 
        'password' => $password
    ];
    $query = new MongoDB\Driver\Query($filter);

    try{
        $result = $manager->executeQuery($dbname, $query);
        $row = $result->toArray();
        $user = $row[0]->username;
        $_SESSION['username'] = $user;
        header("Location: ../index.php");
    }   catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered: ".$e);
    }
?>
