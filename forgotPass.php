<?php include('functions.php');


?>
<!DOCTYPE html>
<html>
<head>
    <style>
        * { margin: 0px; padding: 0px; }
body {
	font-size: 120%;
	background-image: url("images/tds.jpg");
}
.header {
	width: 40%;
	margin: 50px auto 0px;
	color: whitesmoke;
	background:rgba(1,1,1,0.5);
	text-align: center;
	border: 1px solid #B0C4DE;
	border-bottom: none;
	border-radius: 10px 10px 0px 0px;
	padding: 20px;
}
form, .content {
	width: 40%;
	margin: 0px auto;
	padding: 20px;
	border: 1px solid #B0C4DE;
	background:rgba(1,1,1,0.5);
	border-radius: 0px 0px 10px 10px;
}
.input-group {
	margin: 10px 0px 10px 0px;
}
.input-group label {
	display: block;
	text-align: left;
	margin: 3px;
}
.input-group input {
	height: 30px;
	width: 93%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
#user_type {
	height: 40px;
	width: 98%;
	padding: 5px 10px;
	background: white;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.btn {
	padding: 10px;
	font-size: 15px;
	color: white;
	background: #5F9EA0;
	border: none;
	border-radius: 5px;
}
.error {
	width: 92%; 
	margin: 0px auto; 
	padding: 10px; 
	border: 1px solid #a94442; 
	color: #a94442; 
	background: #f2dede; 
	border-radius: 5px; 
	text-align: left;
}
.success {
	color: #3c763d; 
	background: #dff0d8; 
	border: 1px solid #3c763d;
	margin-bottom: 20px;
}

a {
  color: whitesmoke;
}
</style>
</head>
<body>
    <div class="header">
		<a href="TeacherDashv2.php"><img src="images/schoolLogo.jpg" height="150" width="150"></a>
        <h1 style="color:#F8F8FF;">Forgot Password</h1>
    </div>
    <form method="post" action="password-reset-token.php" >
		<br>
        <?php echo display_error(); ?>

        <div class="input-group">
            <label style="color:#F8F8FF;">User ID:</label>
            <input type="text" name="id"  required>
        </div>
        <div class="input-group"><center>
            <button type="submit" class="btn" name="forgot_btn">Submit</button></center>
        </div>
		<p class="link" ><b><a href="login.php">Back</a></b></p>
    </form>
</body>
</html>