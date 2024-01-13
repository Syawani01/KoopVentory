<?php 
require 'functions.php';

if (!isAdmin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

$UserID = $_SESSION['user']['UserID'];
$mysqli_page = $db->query("select login.FullName, login.UserID, admininfo.email, admininfo.IC, admininfo.PhoneNum, admininfo.gender from login join admininfo where login.UserID= '$UserID';");

//THE KEY FOR ENCRYPTION AND DECRYPTION
$encryptionKey = base64_encode(32);

if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $Name = $row_page['FullName'];
    $Gender = $row_page['gender'];
    $Email = $row_page['email'];
    $PhoneNum = $row_page['PhoneNum'];
    $IC = $row_page['IC'];

    $emaildecrypted=decryptthis($Email, $encryptionKey);
    $ICdecrypted=decryptthis($IC, $encryptionKey);
    $Numdecrypted=decryptthis($PhoneNum, $encryptionKey);

}


function decryptthis($data, $key) {
  // Remove the base64 encoding from our key
  $encryption_key = base64_decode($key);
  // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
  list($data, $iv) = explode('::', base64_decode($data), 2);
  return openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

//ENCRYPT FUNCTION
function encryptthis($data, $key) {
  // Remove the base64 encoding from our key
  $encryption_key = base64_decode($key);
  // Generate an initialization vector
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
  $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
  // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
  return base64_encode($encrypted . '::' . $iv);
}



if(isset($_POST["edit"])){
    $name = e($_REQUEST['name']);
    $gender = e($_REQUEST['gender']);
    $email = e($_REQUEST['email']);
    $emailencrypted= encryptthis($email, $encryptionKey);
    $phoneNum = e($_REQUEST['num']);
    $Numencrypted=encryptthis($phoneNum, $encryptionKey);
    $icNum = e($_REQUEST['ic']);
    $ICencrypted=encryptthis($icNum, $encryptionKey);
    $time = date("Y-m-d h:i:s");
    $data = "FullName:".$Name.";"."gender:".$Gender.";"."Email:".$emailencrypted.";"."Phone:".$Numencrypted.";"."IC:".$ICencrypted.";"; 
    
    $sql ="update admininfo set gender='".$gender."', email='".$emailencrypted."', PhoneNum='".$Numencrypted."', IC='".$ICencrypted."' where UserID='".$UserID."'";
    $mysqli->query($sql);

    $sql = "update login set FullName='".$name."' where UserID='".$UserID."'";
    $mysqli->query($sql);

    $get_banner="insert into editlog(DateTime, UserID, Details) 
      VALUES (?,?,?)";
    $run_banners = query($get_banner,[$time,$UserID,$data]);
        if($run_banners){
            echo '<script>alert ("Successfully Update");window.location.href = "user(A).php";</script>';
            
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

.add a{
    background-color:cadetblue;
    color:black;
    font-size:17px;
    padding:5px;
    text-decoration: none;
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
      <a href="#" class=""  ><h1><b>KoopVentory : User Profile</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="user(A).php">Back</a>
  <a class="active" href="change.php">Change Password</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <label>User ID</label>
    <input type="text" name="id" class="form-input" placeholder="" value="<?= $UserID?>" disabled>
    <br>
    <br>
    <label>Name</label>
    <input type="text" name="name" class="form-input" placeholder="" value="<?= $Name?>" required>
    <br>
    <br>
    <label>Gender</label>
    <select name="gender" class="form-input"  value="<?php echo $Gender;?>" required>
      <option value="">Please Select</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
    <br>
    <br>
    <label>Email</label>
    <input type="text" name="email" class="form-input"  value="<?php echo $emaildecrypted ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must input the valid email address" required>
    <br>
    <br>
    <label>Phone Number</label>
    <input type="text" name="num" class="form-input" value="<?php echo $Numdecrypted ?>" required>
    <br>
    <br>
    <label>IC</label>
    <input type="text" name="ic" class="form-input"  value="<?php echo $ICdecrypted ?>" required>
    <br>
    <br>
    <input type="submit" value="Edit" class="btnTable" name="edit"><br>
    </form>
    <br>
    
</div>