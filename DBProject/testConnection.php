<?php
$servername = "ilinkserver.cs.utep.edu";
$username = "wdcroslen";
$password = "*utep2020!";
$database = "f20am_team13";


$currentUser = "";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

$userEmails = getUsersList($conn);
print("\n");
getUserTickets($conn,$userEmails[0]);



if (in_array("jdoe25@miners.utep.edu",$userEmails)){
    print("\nSKRIYAKI TERRIYAKI");
}

exit(0);

//$session = mysql_xdevapi\getSession("mysqlx://$username:$password@$servername");
////$session->sql("DROP DATABASE IF EXISTS addressbook")->execute();
////$session->sql("CREATE DATABASE addressbook")->execute();
////$session->sql("CREATE TABLE addressbook.names(name text, age int)")->execute();
////$session->sql("INSERT INTO addressbook.names values ('John', 42), ('Sam', 33)")->execute();
//
//$schema = $session->getSchema("chillies");
//$table  = $schema->getTable("names");

//$row = $table->select('name', 'age')->execute()->fetchAll();
//var_dump($table);

function getUsersList($conn){
    $query = "SELECT * FROM user";
    $result = mysqli_query($conn,$query);
    $arr =[];
    while($row = mysqli_fetch_array($result)) {
        array_push($arr,$row[2]);
        //First | Last | UtepEmail | Role
        echo ($row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3]); // Print the entire row data
        print("\n");
    }
    return $arr;
}

function getUserTickets($conn,$user){
    $query = "SELECT * FROM Ticket Where UtepEmail = '$user'";
    $result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($result)) {
        echo ($row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3]); // Print the entire row data
        print("\n");
    }
}





