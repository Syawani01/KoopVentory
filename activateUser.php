<?php 
include('functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

//THE KEY FOR ENCRYPTION AND DECRYPTION
$encryptionKey = base64_encode(32);


$UserID = $_GET['UserID'];
$mysqli_page = $db->query("select login.FullName, login.UserID, studentinfo.email, studentinfo.IC, studentinfo.PhoneNum, studentinfo.gender from login join studentinfo 
                  where login.UserID= '$UserID';");

if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $Name = $row_page['FullName'];
    $gender = $row_page['gender'];
    $email = $row_page['email'];
    $PhoneNum = $row_page['PhoneNum'];
    $IC = $row_page['IC'];

    $emaildecrypted=decryptthis($email, $encryptionKey);
    $ICdecrypted=decryptthis($IC, $encryptionKey);
    $Numdecrypted=decryptthis($PhoneNum, $encryptionKey);
}

//ENCRYPT FUNCTION
function decryptthis($data, $key) {
  // Remove the base64 encoding from our key
  $encryption_key = base64_decode($key);
  // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
  list($data, $iv) = explode('::', base64_decode($data), 2);
  return openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
}


if(isset($_POST["delete"])){
  $get_banner="update login set status=? where UserID=?";
  $run_banners = query($get_banner,['inactive', $UserID]);
  if($run_banners){
    echo '<script>alert ("Successfully Inactive Account");window.location.href = "user(A).php";</script>';
  }else{
    echo '<script>alert ("FAIL! Please try again.");window.location.href = "user(A).php";</script>';
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    * {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  background-image: url("images/tds.jpg");
  padding: 5px 5px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a.active:hover {
  background-color: darkgreen;
  color: black;
}

.header a.active {
  background-color: cadetblue;
  color: black;
}

.header-right a.active {
  background-color: cadetblue;
  color: black;
}

.header-right {
  float: center;
  padding: 0px 250px;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  
  .header-right {
    float: none;
  }
}

body {
    margin:0;
    padding:0;
    background: white;
}

form {
	width: 80%;
	margin: 0px auto;
	padding: 20px;
	border: 4px solid darkcyan;
	background: white;
	border-radius: 0px 0px 10px 10px;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}
label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: cadetblue;
  color: black;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: darkgreen;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 40px;
}


a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
  
}

</style>
</head>
<body>
<div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
</div>

<nav style="justify-content: space-between;align-items:center">
  
    <div class="header">
      <div class="logo"><a href="user.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : Activate User</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="user(A).php">Back</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <label>User ID</label>
    <input type="text" name="id" class="form-input" placeholder="" value="<?= $UserID?>" disabled required>
    <br>
    <br>
    <label>Name</label>
    <input type="text" name="Name" class="form-input" placeholder="" value="<?= $Name?>" disabled required>
    <br>
    <br>
    <label>Gender</label>
    <input type="text" name="gender" class="form-input"  value="<?= $gender?>" disabled required>
    <br>
    <br>
    <label>Email</label>
    <input type="text" name="Email" class="form-input" value="<?= $emaildecrypted?>" disabled required>
    <br>
    <br>
    <label>Phone Number</label>
    <input type="text" name="PhoneNum" class="form-input" value="<?= $Numdecrypted?>" disabled required>
    <br>
    <br>
    <label>IC</label>
    <input type="text" name="IC" class="form-input" value="<?= $ICdecrypted?>" disabled required>
    <br>
    <br>
    <input type="submit" value="Inactive" class="btnTable" name="delete"><br>
    <br>
    </form>
    <br>
    
</div>