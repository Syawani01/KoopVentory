<?php include('functions.php');

if(isset($_POST['resetPass']) ){
    $user = $_POST['id'];
    $token = $_POST['reset_link_token'];
    $password = $_POST['pass1'];
    $Cpassword = $_POST['pass2'];
    $me=password_hash($Cpassword, PASSWORD_DEFAULT );
    if($password==$Cpassword){
        $query = mysqli_query($db,"SELECT * FROM `token` WHERE `reset_link_token`='".$token."' and `UserID`='".$user."'");
        $row = mysqli_num_rows($query);
        if($row){

            mysqli_query($db,"UPDATE login set  pass='" . $me . "' WHERE UserID='" . $user . "'");
            $get_banner="update token set reset_link_token=?, exp_date=? where UserID=?";
            $run_banners = query($get_banner,[null, null, $user]);
            if($run_banners){
                echo '<script>alert ("Successfully Update Password");window.location.href = "login.php";</script>';
            }else{
               echo '<script>alert ("FAIL! Please try again.");window.location.href = "login.php";</script>';
            }
        }else{
            echo '<script>alert ("Something goes wrong");window.location.href = "login.php";</script>';
        }
    }else{
        echo '<script>alert ("Your Password does not match");window.location.href = "login.php";</script>';
    }
}

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
</style>
</head>
<body>
    <div class="header">
		<a href="TeacherDashv2.php"><img src="images/schoolLogo.jpg" height="150" width="150"></a>
        <h1 style="color:#F8F8FF;">Forgot Password</h1>
    </div>
    <?php
    if($_GET['UserID']){
        $ID = $_GET['UserID'];
        $token = $_GET['reset_token'];
        $query = mysqli_query($db, "SELECT * FROM `token` WHERE `reset_link_token`='".$token."' and `UserID`='".$ID."';");
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $curDate = date("Y-m-d H:i:s ");
        if (mysqli_num_rows($query) > 0) {
            $row= mysqli_fetch_array($query);

            $date1 = new DateTime($row['exp_date']);
            $date2 = new DateTime($curDate);
            $diff = $date2->diff($date1);
            $hours = $diff->h;
            $hours = $hours + ($diff->days*24);

            if($hours <= 24){ ?>
                <form action="" method="post">
                    <br>
                    <?php echo display_error(); ?>

                    <div class="input-group">
                        <label style="color:#F8F8FF;">New Password :</label>
                        <input type="password" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    </div>
                    <div class="input-group">
                        <label style="color:#F8F8FF;">Confirm Password ;</label>
                        <input type="password" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        <input type="hidden" value="<?php echo $ID; ?>" name="id"/>
                        <input type="hidden" name="reset_link_token" value="<?php echo $token;?>">
                    </div>
                    <div class="input-group"><center>
                        <button type="submit" class="btn" name="resetPass">Submit</button></center>
                    </div>
                </form>
            <?php }else{?>
                <form action="" method="post">
                    <label><center> This link has already expired</center></label>
                </form>

            <?php }
        }
    }?>

</body>
</html>