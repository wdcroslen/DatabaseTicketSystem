<?php

if (isset($_SESSION['userName'])) {
    session_destroy();
}
session_start();
$servername = "ilinkserver.cs.utep.edu";
$username = "wdcroslen";
$password = "*utep2020!";
$database = "f20am_team13";
$currentUser = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

$userEmails = getUsersList($conn);
//print("\n");
//getUserTickets($conn, $userEmails[0]);

//if (in_array("jdoe25@miners.utep.edu", $userEmails)) {
//    print("\nSKRIYAKI TERRIYAKI");
//}


function userExists($user){
    global $userEmails;
    if (in_array($user, $userEmails)) {
        return true;
    }
    return false;
}

function getUsersList($conn){
    $query = "SELECT * FROM user";
    $result = mysqli_query($conn,$query);
    $arr =[];
    while($row = mysqli_fetch_array($result)) {
        array_push($arr,$row[2]);
        //First | Last | UtepEmail | Role
//        echo ($row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3]); // Print the entire row data
//        print("\n");
    }
    return $arr;
}

if($_SERVER['REQUEST_METHOD']=='POST') {
    echo "YEEET";
    display();
}

function display(){
//          TODO: CHECK IF USER IN USER LIST
    $_SESSION['user'] = $_POST["usernameTextbox"];
    if(userExists($_POST["usernameTextbox"])){
        header('location:userRequest.php');
    }
    else{
        echo("<div class ='center'> Incorrect Username </div>");
    }
}

    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>SignIn</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<!--<body>-->
<!--<script src="script.js"></script>-->
<!--</body>-->

<body id="custom" class="login">

<div class="loginLogo"></div>
<div class="loginTitle"></div>




<!---------------------------------------------------------------------------------------------------------------------------->
<!--    <h1>Create Student</h1>-->
    <!-- styling of the form for bootstrap https://getbootstrap.com/docs/4.5/components/forms/ -->
<!--    <form action="index.php" method="post">-->
<!--        <div class="form-group">-->
<!--            <label for="id">ID</label>-->
<!--            <input class="form-control" type="text" id="id" name="id">-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="first_name">First Name</label>-->
<!--            <input class="form-control" type="text" id="first_name" name="first_name">-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="middle_name">Middle Name</label>-->
<!--            <input class="form-control" type="text" id="middle_name" name="middle_name">-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="last_name">Last Name</label>-->
<!--            <input class="form-control" type="text" id="last_name" name="last_name">-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <input class="btn btn-primary" name='Submit' type="submit" value="Submit">-->
<!--        </div>-->
<!--    </form>-->
<!--    <div>-->
<!--        <br>-->
<!--        <a href="student_menu.php">Back to Student Menu</a></br>-->
<!--    </div>-->

<!---------------------------------------------------------------------------------------------------------------------------->



<div id="primaryLoginFormDiv" class="center">
    <div>
        <?php


           ?>

        <script>
        function validateUser() {
            var x = document.forms["loginForm"]["usernameTextbox"].value;
            var y = document.forms["loginForm"]["passwordTextbox"].value;
            if (x == "" || y == "") {
                alert("Name and Password must be filled out");
                return false;
            }
        }
        </script>
    </div>
    <form id="loginForm" action="index.php" method="post" onsubmit="return validateUser()">
        <input type="text" id="usernameTextbox" name="usernameTextbox" placeholder="User Name (e.g., domain\name)" maxlength="100">
        <input type="password" id="passwordTextbox" name="passwordTextbox" placeholder="Password" maxlength="100" data-localize="Password">
        <div class="forgotPassword"><a id="forgotPasswordAnchor" href="https://adminapps.utep.edu/ssoactions" title="Reset your password or unlock your account." data-localize="ForgotPassword">New Account/Change Password</a></div>
        <div>
            <button type="submit" class="button" id="loginSubmitButton">
                <a href = "userRequest.php"></a>
                <div class="cui-button-overlay">
                    <span data-localize="LoginSubmitButton">Log in</span>
                </div>
            </button>

        </div>

    </form>
</div>


</body>
<!--<footer>© 2020 Dell Inc. ALL RIGHTS RESERVED</footer>-->
</html>
<?php
//    session_start();
//    $_SESSION["username"] = "green";

//$_SESSION['userName'] = 'Root';

if (isset($_POST['Submit'])) {

    echo "YEET";
    /**
     * Grab information from the form submission and store values into variables.
     */
    /*<td><a href="userRequest.php?Sid=<?php echo $row[0] ?>">Update</a></td>*/
    $sid = isset($_POST['id']) ? $_POST['id'] : " ";

//    $sfirstName = isset($_POST['first_name']) ? $_POST['first_name'] : " ";
//    $smiddleName = isset($_POST['middle_name']) ? $_POST['middle_name'] : " ";
//    $slastName = isset($_POST['last_name']) ? $_POST['last_name'] : " ";
}