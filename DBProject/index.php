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
    <form id="loginForm" action="" method="post">
        <input type="text" id="usernameTextbox" name="usernameTextbox" placeholder="User Name (e.g., domain\name)" maxlength="100">
        <input type="password" id="passwordTextbox" name="passwordTextbox" placeholder="Password" maxlength="100" data-localize="Password">
        <div class="forgotPassword"><a id="forgotPasswordAnchor" href="https://adminapps.utep.edu/ssoactions" title="Reset your password or unlock your account." data-localize="ForgotPassword">New Account/Change Password</a></div>
        <div>
            <button type="submit" class="button" id="loginSubmitButton">
                <div class="cui-button-overlay">
                    <span data-localize="LoginSubmitButton">Log in</span>
                </div>
            </button>
<!--            <br></br>-->
        </div>

    </form>
</div>


</body>
<!--<footer>© 2020 Dell Inc. ALL RIGHTS RESERVED</footer>-->
</html>