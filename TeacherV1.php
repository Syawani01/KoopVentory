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

$UserID = $_GET['UserID'];
$mysqli_page = $db->query("SELECT substring_index(substring_index(Details, ';', 1), ':', -1) AS 'FullName', substring_index(substring_index(Details, ';', 2), ':', -1) 
               AS 'gender', substring_index(substring_index(Details, ';', 3), ':', -1) AS 'email', substring_index(substring_index(Details, ';', 4), ':', -1) 
               AS 'Phone', substring_index(substring_index(Details, ';', 5), ':', -1) AS 'IC', DateTime from editlog where UserID= '$UserID' And DateTime IN (SELECT max(DateTime) 
               FROM editlog);");

//THE KEY FOR ENCRYPTION AND DECRYPTION
$encryptionKey = base64_encode(32);

if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $name = $row_page['FullName'];
    $gender = $row_page['gender'];
    $email = $row_page['email'];
    $PhoneNum = $row_page['Phone'];
    $IC = $row_page['IC'];
    $time = $row_page['DateTime'];

    $emaildecrypted=decryptthis($email, $encryptionKey);
    $ICdecrypted=decryptthis($IC, $encryptionKey);
    $Numdecrypted=decryptthis($PhoneNum, $encryptionKey);

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $curDate = date("Y-m-d H:i:s ");
    $date1 = new DateTime($time);
    $date2 = new DateTime($curDate);
    $diff = $date2->diff($date1);
    $hours = $diff->h;
    $hours = $hours + ($diff->days*24);
    if($hours > 24){
      $get_banner="delete FROM editlog where UserID=?";
      $run_banners = query($get_banner,[$UserID]);
      echo '<script>alert ("Previous data already expired");window.location.href = "user(A).php";</script>';
    }
}else{
    echo '<script>alert ("No Edit data");window.location.href = "user(A).php";</script>';
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



if(isset($_POST["Restore"])){
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $time = date("Y-m-d H:i:s ");
    $mysqli_page = $db->query("SELECT Details FROM editlog WHERE UserID='$UserID' AND DateTime IN (SELECT max(DateTime) FROM editlog);");
    $page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $details = $page['Details'];

    $get_banner="update teacherinfo set gender=?, email=?, PhoneNum=?, IC=? where UserID=?";
    $run_banners = query($get_banner,[$gender,$email,$PhoneNum,$IC,$UserID]);

    $get_banner="insert into rollback(UserID, Datetime, Details) 
    VALUES (?,?,?)";
    $run_banners = query($get_banner,[$UserID, $time, $details]);

    $get_banner="delete FROM editlog where UserID=?";
    $run_banners = query($get_banner,[$UserID]);

    if($run_banners){
      echo '<script>alert ("Successfully Restore");window.location.href = "user(A).php";</script>';
            
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
      <a href="#" class=""  ><h1><b>KoopVentory : Previous Teacher Data</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="editTeacher.php?UserID=<?php echo $UserID; ?>">Back</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <label>Full Name</label>
    <input type="text" name="name" class="form-input"  value="<?= $name?>" disabled required>
    <input type="hidden" name="N" value="<?php echo $name; ?>">
    <br>
    <br>
    <label>Gender</label>
    <input type="text" name="gender" class="form-input"  value="<?= $gender?>" disabled required>
    <input type="hidden" name="G" value="<?php echo $gender; ?>">
    <br>
    <br>
    <label>Email</label>
    <input type="text" name="Email" class="form-input" value="<?= $emaildecrypted?>" disabled required>
    <input type="hidden" name="E" value="<?php echo $email; ?>">
    <br>
    <br>
    <label>Phone Number</label>
    <input type="text" name="PhoneNum" class="form-input" value="<?= $Numdecrypted?>" disabled required>
    <input type="hidden" name="PN" value="<?php echo $PhoneNum; ?>">
    <br>
    <br>
    <label>IC</label>
    <input type="text" name="IC" class="form-input" value="<?= $ICdecrypted?>" disabled required>
    <input type="hidden" name="ic" value="<?php echo $IC; ?>">
    <br>
    <br>
    <input type="submit" value="Restore Data" class="btnTable" name="Restore"><br>
    <br>
    </form>
    <br>
    
</div>