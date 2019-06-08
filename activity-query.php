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
<form action = "activity-query.php" method = "GET"><select name="query-options"><option value="post-query">Post</option><option value="photo-query">Photo</option><option value="user-query">People</option></select><input type = "text" name = "keyword"></input><input type="submit" value="Search"></form>
<br/><hr>
<?php
$search_mode = $_GET["query-options"];
$keyword = $_GET["keyword"];
if ($search_mode == "post-query"){
	if ($stmt = $mysqli->prepare("Select Users.uid, Users.username, Post.message, Post.add_loc, Users.curr_lat, Users.curr_long, Post.timestp from Users, Post, Friends where Friends.uid1 = ? and Friends.uid2 = Post.uid and Users.uid = Post.uid and message LIKE '%$keyword%' ORDER BY Post.timestp DESC;")){
	$stmt->bind_param("s", $_SESSION['input_username']);
	$stmt->execute();
	$stmt->bind_result($uid, $username, $message, $add_loc, $lat, $long, $timestp);
	while ($stmt->fetch()){
		echo "<div class = 'post'><div class = 'name'>$username:</div><div class = 'post-content'>$message</div>";
		if ($add_loc == "yes" and $lat != NULL and $long != NULL){
			echo "<p style = 'font-size: 10px; float: right;'>$timestp</p> | latitude: $lat | longitude: $long";}
		else{
			echo "<p style = 'font-size: 10px; float: right;'>Posted on: $timestp</p>";}
		echo "</div>";}
	}
}
else if($search_mode == "photo-query"){
	if ($stmt = $mysqli->prepare("Select Users.uid, Users.username, Photo.file_path, Photo.longitude, Photo.latitude, Photo.ptime, Photo.view_opt from Users, Photo where Users.uid = Photo.uid and ((Photo.uid = $keyword) OR (Photo.longitude = $keyword) OR (Photo.latitude = $keyword))ORDER BY Photo.ptime DESC;")){
	$stmt->execute();
	$stmt->bind_result($uid, $username, $path, $long, $lat, $timestp, $view_opt);
	while ($stmt->fetch()){
		if ($view_opt == "public" and $path!=""){
			echo "<div class = 'post'><div class = 'name'>$username:</div><div class = 'post-content'>$path</div>";
			if ($lat != NULL and $long != NULL){
				echo "<p style = 'font-size: 10px; float: right;'>$timestp</p> | latitude: $lat | longitude: $long";}
			else{
				echo "<p style = 'font-size: 10px; float: right;'>Posted on: $timestp</p>";}
	echo "</div>";}}}
}
else{
	if ($stmt = $mysqli->prepare("Select uid, username, curr_long, curr_lat from Users where uid = ? or username = ?")){
	$stmt->bind_param("ss", $keyword, $keyword);
	$stmt->execute();
	$stmt->bind_result($uid, $username, $long, $lat);
	echo "<table border = '1'>\n <col width='150'><col width='150'><col width='150'><col width='150'><col width='150'>";
	echo "<tr>";
    echo "<td>uid</td><td>username</td><td>longitude</td><td>latitude</td><td></td>";
	echo "</tr>\n";
	while ($stmt->fetch()){
		echo "<tr>";
		echo "<td>$uid</td><td>$username</td><td>$long</td><td>$lat</td><td><form action='profile.php' style = 'display: inline;' method = 'POST'><input type='hidden' name='profile-uid' value='$uid'/><input type='submit' value ='Profile'></form></td>";
		echo "</tr>\n";
	}}
}
?>
</div>
</body>
</html>