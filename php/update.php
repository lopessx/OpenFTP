<?php
    include 'db.inc.php';
    $bulk = new MongoDB\Driver\BulkWrite;

    $id = $_POST["id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        $bulk->update(['_id' => new MongoDB\BSON\ObjectId($id)],
        [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'password' => $password
        ]);
        $result = $manager->executeBulkWrite($dbname, $bulk);
        header("Location: ../userlist.php");
    }catch(MongoDB\Driver\Exception\Exception $e){
        die("Error Encountered ".$e);
    }
?>