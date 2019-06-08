<html>
<head>
<title>Home Page</title>
<link rel="stylesheet" type="text/css" href="homepage-style.css">
</head>
<body>
<h1 style = "float:left;">Tourini</h1>
<div class = "white-decor"></div>
<div class = "content-holder">
<div class = "nav-menu">
<ul>
	<li><a href = "home_page.php">Browse</a></li>
	<li><a href = "profile.php">Profile</a></li>
	<li><a href = "http://localhost/upload-photo.php">Upload Photo</a></li>
	<li><a href = "http://localhost/upload-post.php">Upload Post</a></li>
	<li><a href = "http://localhost/setting.php">Setting</a></li>
	<li><a href = "http://localhost/friend-requests.php">Friend Requests</a></li>
	<li><a href = "http://localhost/manage-circles.php">Manage Circles</a></li>
	<li><a href = "http://localhost/manage-friends.php">Manage Friends</a></li>
	<li><a href = "http://localhost/main.html">Log Out</a></li>
</ul>
</div>
</div>
<?php
session_start();?>
<?php

$mysqli = new mysqli("localhost", "root", "", "tourini");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}?>
<div class = "greeting">
<?php
if ($stmt = $mysqli->prepare("Select uid, username, password from Users where uid = ?")){
	$stmt->bind_param("s", $_SESSION['input_username']);
	$stmt->execute();
	$stmt->bind_result($uid, $username, $password);
	$stmt->fetch();
	echo "Welcome back, $username.";
	$stmt->close();
}
?>
<div>
<div class = "main-content">
<h3>Friend List</h3><hr>
<?php
if ($stmt = $mysqli->prepare("Select Users.uid, Users.username, Users.curr_lat, Users.curr_long from Users, Friends WHERE Users.uid = Friends.uid2 and Friends.uid1 = ?")){
	$stmt->bind_param("s", $_SESSION['input_username']);
	$stmt->execute();
	$stmt->bind_result($uid, $username, $lat, $long);
	echo "<table border = '1'>\n <col width='140'><col width='200'><col width='200'><col width='200'>";
	echo "<tr>";
    echo "<td>Username</td><td>Latitude</td><td>Longitude</td><td>Option</td>";
	echo "</tr>\n";
	while ($stmt->fetch()){
		echo "<tr>";
		echo "<td>$username</td><td>$lat</td><td>$long</td><td><form action='profile.php' style = 'display: inline;' method = 'POST'><input type='hidden' name='profile-uid' value='$uid'/><input type='submit' value ='Profile'></form><form action = 'delete-friend.php' style = 'display: inline;' method = 'GET'><input type = 'submit' value = 'Delete'></input><input type='hidden' name='delete-uid' value='$uid'/></form></td>";
		echo "</tr>\n";
	}
	echo "</table>";
	}
?>
</div>
</body>
</html>