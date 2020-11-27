<!--
/**
 * CS 4342 Database Management
 * @author Instruction team with contribution from L. Garnica and K. Apodaca
 * @version 2.0
 * Description: The purpose of these file is to provide PhP basic elements for an interface to access a DB.
 * Resources: https://getbootstrap.com/docs/4.5/components/alerts/  -- bootstrap examples
 *
 * This file inserts a new record  into the table Student of your DB.
 */
-->
<?php

$servername = "ilinkserver.cs.utep.edu";
$username = "wdcroslen";
$password = "*utep2020!";
$database = "f20am_team13";
$currentUser = "";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password, $database);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CS4342 Create Student</title>

    <!-- Importing Bootstrap CSS library https://getbootstrap.com/ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<script>
    function passwordMatch(){
        var p = document.getElementById("password").value;
        var rp = document.getElementById("re-password").value;

        if (p === rp){
            var t = true;
        } else {
            alert("Passwords must match");
            return false;
        }
        return true;

    }
</script>
<body style="background-color: #041E42; color:white;" >
<div style="margin-top: 20px" class="container">
    <h1 style="color:#FF8200;">Create Student</h1>
    <!-- styling of the form for bootstrap https://getbootstrap.com/docs/4.5/components/forms/ -->
    <form action="createUser.php" method="post" onsubmit="return passwordMatch()">
        <div class="form-group">
            <label for="email">UTEP Email</label>
            <input class="form-control" type="text" id="email" name="email"required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input class="form-control" type="text" id="first_name"  name="first_name"required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input class="form-control" type="text" id="last_name" name="last_name"required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" id="password" name="password"required>
        </div>
        <div class="form-group">
            <label for="re-password">Retype-Password</label>
            <input class="form-control" type="password" id="re-password" name="re-password" required>
        </div>

        <label for="role">Tell Us Your UTEP Role</label>
        <select name="role" id="role" class="select">
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
            <option value="Staff">Staff</option>
        </select>

        <div class="form-group">
            <input class="btn btn-primary" name='Submit' type="submit" value="Submit">
        </div>
    </form>
    <div>
        <br>
        <a href="index.php">Back to Student Menu</a></br>
    </div>

    <!-- jQuery and JS bundle w/ Popper.js -->

    <?php
    if (isset($_POST['Submit'])){

        /**
         * Grab information from the form submission and store values into variables.
         */
        $sEmail= isset($_POST['email']) ? $_POST['email'] : " ";
        $sfirstName = isset($_POST['first_name']) ? $_POST['first_name'] : " ";
        $slastName = isset($_POST['last_name']) ? $_POST['last_name'] : " ";
        $sPassword = isset($_POST['password']) ? $_POST['password'] : " ";
        $role = isset($_POST['role']) ? $_POST['role'] : " ";

        //Insert into Student table;
        $passTest = password_hash($sPassword, PASSWORD_DEFAULT);
        $queryStudent  = "INSERT INTO User (FirstName,LastName,UTEPEmail,Role,Password)
                VALUES ('".$sfirstName."','".$slastName."','".$sEmail."','".$role."','".$passTest."');";

        if ($conn->query($queryStudent) === TRUE) {
            echo "<br> New record created successfully for student ".$sEmail;

        } else {
            echo "<br> The record was not created, the query, generated the error <br>" . $conn->error;
        }

        // To redirect the page to the student menu right after the query is executed, use the following statement
        // header("Location: student_menu.php");
    }
    ?>


</body>

</html>