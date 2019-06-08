<html>
<head>
<title>Create new account</title>
<link rel="stylesheet" type="text/css" href="create_account_style.css">
</head>
<body>

<div class = "headerimg"><img src = "http://localhost/headerimg.jpg"/></div>
<div class = "white-decor"></div>
<h1 style ="float:left;">Tourini</h1><div id ="symb">®</div>
<h5>Connect with Travelers™</h5>
<hr>
<?php

$mysqli = new mysqli("localhost", "root", "", "tourini");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
<div class = "text-area">
<a href = "main.html">Already have an account? Log in here.</a>

<div class = "sign-up"><br/>
<form name = "new-sign-up" method = "GET" action = "sign-up-request.php">
Username (Login Name): <input type = "text" width = "20px" name = "new_login_name" maxlength="20"><br/>
Display Name: <input type = "text" width = "20px" name = "new_display_name" maxlength="20"><br/>
Password: <input type = "text" width = "20px" name = "new_acc_password" maxlength="20"><br/><br/>
<input type="submit" value="Create Account"></form></div>

</div>
</body>
</html>