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
global $conn;
$conn = new mysqli($servername, $username, $password, $database);


//$_SESSION['conn'] = $conn;

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
    }
    return $arr;
}

if($_SERVER['REQUEST_METHOD']=='POST') {
    display($conn);
}

function validUser($conn){
    $userInputEmail = isset($_POST['usernameTextbox']) ? $_POST['usernameTextbox'] : " ";
    $userInputPassword = isset($_POST['passwordTextbox']) ? $_POST['passwordTextbox'] : " ";
    $passQuery = "Select password from user where UtepEmail = '$userInputEmail'";
    $userPass = mysqli_query($conn,$passQuery);
    $row = mysqli_fetch_array($userPass);

    if (password_verify($userInputPassword,$row[0])){
        return true;
    }
    return false;
}
function validAdmin($conn){
    $userInputEmail = isset($_POST['usernameTextbox']) ? $_POST['usernameTextbox'] : " ";
    $userInputPassword = isset($_POST['passwordTextbox']) ? $_POST['passwordTextbox'] : " ";
    $passQuery = "Select password from techmember where username = '$userInputEmail'";
    $adminPass = mysqli_query($conn,$passQuery);
    $row = mysqli_fetch_array($adminPass);

    if (password_verify($userInputPassword,$row[0])){
        return true;
    }
    return false;
}


function display($conn){
    $_SESSION['user'] = $_POST["usernameTextbox"];
//    if(userExists($_POST["usernameTextbox"])){
    if (validAdmin($conn)){
        $URL="admin.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
//        header('location:admin.php');
        exit();
    }
    else if (validUser($conn)){
        $URL="userRequest.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
//        header('location:userRequest.php');
        exit();
    }
    else{
        echo("<div class ='center'> Incorrect Username/Password </div>");
    }
}

if (isset($_POST['Submit'])) {

    echo "YEET";
    /**
     * Grab information from the form submission and store values into variables.
     */
    /*<td><a href="userRequest.php?Sid=<?php echo $row[0] ?>">Update</a></td>*/
    $sid = isset($_POST['id']) ? $_POST['id'] : " ";
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


<div id="primaryLoginFormDiv" class="center">
    <div>
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
        <div class="forgotPassword"><a id="forgotPasswordAnchor" href="createUser.php" title="Reset your password or unlock your account." data-localize="ForgotPassword">New Account/Change Password</a></div>
<!--        https://adminapps.utep.edu/ssoactions-->
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