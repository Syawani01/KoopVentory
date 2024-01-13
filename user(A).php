<?php 
include('functions.php');
require 'headerA.php';


if($_SESSION['user']['TypeName'] == 'teacher'){
    header('location: user(T).php');
}else if (!isAdmin()){
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

//DECRYPT FUNCTION
function decryptthis($data, $key) {
// Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

if (isset($_POST['add'])) {
    global $db, $username, $errors;
    $type = e($_POST['TypeName']);

    //to get max id number
    $query="select max(UserID) AS 'max' from login where TypeName='$type'";
    $resultMe = mysqli_query($db,$query); 
    $row = mysqli_fetch_assoc($resultMe);
    $ID=$row["max"];
    $letter = $ID[0];
    $number = $ID[1].$ID[2].$ID[3];
    $newUser=e($letter.sprintf("%03d", $number+1));
 
    $name = e($_POST['Name']);

    $validName="/^[a-zA-Z ]*$/";
    if (!preg_match ("/^[a-zA-Z ]*$/", $name) ) {  
        echo '<script>alert ("Only alphabets and whitespace are allowed.");window.location.href = "user(A).php";</script>';
    }
    
    $email = e($_POST['Email']);
    $emailencrypted= encryptthis($email, $encryptionKey);
    $IC = e($_POST['IC']);

    if (!preg_match ("/[0-9]*$/", $IC) ) {  
        echo '<script>alert ("No alphanets and special caracter allowed.");window.location.href = "user(A).php";</script>';
    }

    $ICencrypted=encryptthis($IC, $encryptionKey);
    $gender = e($_POST['gender']);
    $phone = e($_POST['PhoneNum']);

    if (!preg_match ("/[0-9]*$/", $phone) ) {  
        echo '<script>alert ("No alphanets and special caracter allowed.");window.location.href = "user(A).php";</script>';
    }
    $Numencrypted=encryptthis($phone, $encryptionKey);

    $get_banner="insert into login(UserID, FullName, UserPass, Pass, TypeName, status) 
    VALUES (?,?,?,?,?,?)";
    $Pass=password_hash($newUser, PASSWORD_DEFAULT );
    $run_banners = query($get_banner,[$newUser,$name,$Pass,$Pass,$type,'active']);
    if ($run_banners) {
        if($type == 'teacher'){
            $get_banner="insert into teacherinfo (UserID, gender, email, PhoneNum, IC)
                VALUES (?,?,?,?,?)";
            $run_banners = query($get_banner,[$newUser,$gender,$emailencrypted,$Numencrypted,$ICencrypted]);

            $get_banner="insert into token (UserID)
                VALUES (?)";
            $run_banners = query($get_banner,[$newUser]);
            echo '<script>alert ("Successfully add teacher");window.location.href = "user(A).php";</script>';
        }
        else{
            $get_banner="insert into studentinfo (UserID, gender, email, PhoneNum, IC)
                    VALUES (?,?,?,?,?)";
            $run_banners = query($get_banner,[$newUser, $gender, $emailencrypted, $Numencrypted, $ICencrypted]);

            $get_banner="insert into token (UserID)
                VALUES (?)";
            $run_banners = query($get_banner,[$newUser]);
            echo '<script>alert ("Successfully add student");window.location.href = "user(A).php";</script>';

        }
    } else {
        echo '<script>alert ("FAIL! Please try again.");window.location.href = "user(A).php";</script>';
    }
}

$ID = e($_SESSION['user']['UserID']);

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
  background-color: #f1f1f1;
  padding: 0px 5px;
  background-image: url("images/tds.jpg");
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

.header a.active {
  background-color: cadetblue;
  color: black;
}

.header-right {
  float: right;
}



.right a.active {
  background-color: cadetblue;
  color: black;
  padding: 7px 10px;
}

.right {
  float: right;
  padding: 5px 5px;
}

body {
    margin:0;
    padding:0;
    background: white;
}

.nav ul{
    list-style:none;
    background-color:cadetblue;
    text-align: center;
    padding: 0;
    margin:0;
}

.nav li{
    display: inline-block;
}

.nav a{
    text-decoration: none;
    color:black;
    width:140px;
    display:block;
    padding:10px;
    font-size:20px;
    font-family: Helvetica;
    transition: 0.4s;
}

.nav a:hover{
    background-color:darkgreen;
    transition:0.4s;
}

.add a{
    background-color:cadetblue;
    color:black;
    font-size:17px;
    padding:5px;
    text-decoration: none;
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 10px 10px 10px 10px;
}

table a{
    padding: 7px 10px;
    font-size: 16px;
    background-color: cadetblue;
    font-family: cursive;
    text-align: center;
    color: black;
    width: 25%;
}

.tr a:hover{
    background-color:darkgreen;
    transition:0.4s;
}

form {
	width: 80%;
	margin: 0px auto;
	padding: 20px;
	border: 1px solid #B0C4DE;
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
  color: white;
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
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

.kanan,
.kiri
{
    display: inline-block;
    width: 48%;
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

<div class="nav">
    <ul>
        <li><a href="Dash.php">Home</a></li>
        <li><a href="user(A).php">User</a></li>
        <li><a href="Inventory.php">Inventory</a></li>
        <li><a href="Transaction.php">Transaction</a></li>
        <li><a href="Report.php">Report</a></li>
    </ul>
</div>
<h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp USER</h2>
<div class="container1">
  <form action="user(A).php" method="post">
    <h4>Add New User</h4>
    <div class="kanan">
        <div class="row">
            <div class="col-25">
                <label>Full Name</label>
            </div>
            <div class="col-75">
                <input type="text" name="Name" class="form-input" required>
            </div>
        </div>


        <div class="row">
            <div class="col-25">
                <label>Email</label>
            </div>
            <div class="col-75"> 
                <input type="text" name="Email" class="form-input" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must input the valid email address" required>
            </div>
        </div>

        <div class="row">
            <div class="col-25">
            <label>User Type</label>
            </div>
            <div class="col-75">
                <select name="TypeName" id="TypeName" class="form-input" required>
                    <option value="">Please Select</option>
                    <option value="teacher">teacher</option>
                    <option value="student">student</option>
                </select>
            </div>
        </div>
    </div>
            
    <div class="kiri">
        

        <div class="row">
            <div class="col-25">
                <label>IC Number</label>
            </div>
            <div class="col-75">
                <input type="text" name="IC" class="form-input" pattern="(?=.*[0-9]).{12,}" placeholder="021209051366"required>
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label>Gender</label>
            </div>
            <div class="col-75">
                <select name="gender" id="gender" class="form-input" required>
                    <option value="">Please Select</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-25">
                <label>Phone Number</label>
            </div>
            <div class="col-75">
                <input type="text" name="PhoneNum" class="form-input" pattern="(?=.*[0-9]).{7,}" placeholder="01122948586" required>
            </div>
        </div>
    </div>
    
    <div class="row">
      <input type="submit" name="add" value="Add">
    </div>
  </form>
</div>
<br>
<br>
<table style="margin:0 auto; width:85%; background-color:cadetblue">
    <tr>
        <th style="width:30%">List of Teacher</th>
    </tr>
</table>

<table style="margin:0 auto;width:85%;text-align:center;">
    <thead>
        <tr>
            <th><strong>Name</strong></th>
            <th><strong>ID</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>IC Number</strong></th>
            <th><strong>Phone Number</strong></th>
            <th><strong>Gender</strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Status</strong></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $count=1;
    $query="select login.FullName, login.UserID, teacherinfo.email, teacherinfo.IC, teacherinfo.PhoneNum, teacherinfo.gender from login 
            join teacherinfo where login.TypeName= 'teacher' AND login.status= 'active' AND login.UserID=teacherinfo.UserID GROUP BY login.UserID;";
    $resultMe = mysqli_query($db,$query);
    while($row = mysqli_fetch_assoc($resultMe)) { 

        $emaildecrypted=decryptthis($row["email"], $encryptionKey); 
        $ICdecrypted=decryptthis($row["IC"], $encryptionKey);
        $Numdecrypted=decryptthis($row["PhoneNum"], $encryptionKey);?>
        <tr>
        <td align="center"><?php echo $row["FullName"]; ?></td>
        <td align="center"><?php echo $row["UserID"]; ?></td>
        <td align="center"><?php echo $emaildecrypted; ?></td>
        <td align="center"><?php echo $ICdecrypted; ?></td>
        <td align="center"><?php echo $Numdecrypted; ?></td>
        <td align="center"><?php echo $row["gender"]; ?></td>
        <td align="center"><a href="editTeacher.php?UserID=<?php echo $row["UserID"]; ?>">Edit</a></td>
        <td align="center"><a href="activateUser.php?UserID=<?php echo $row["UserID"]; ?>">Active</a></td>
        </tr>
        <?php } ?>
    <?php $count++; ?> 


</tbody>
</table>
<div class="right">
  <br>
  <a class="active" href="inactiveTeacher.php">Previous Teacher</a>
</div>


<br>
<br>
<br>
<table style="margin:0 auto; width:85%; background-color:cadetblue">
    <tr>
        <th style="width:30%">List of Student</th>
    </tr>
</table>

<table style="margin:0 auto;width:85%;text-align:center;">
<thead>
<tr>
<th><strong>Student Name</strong></th>
<th><strong>Student ID</strong></th>
<th><strong>Email</strong></th>
<th><strong>IC Number</strong></th>
<th><strong>Phone Number</strong></th>
<th><strong>Gender</strong></th>
<th><strong>Edit</strong></th>
<th><strong>Status</strong></th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$query="select login.FullName, login.UserID, studentinfo.email, studentinfo.IC, studentinfo.PhoneNum, studentinfo.gender from login 
        join studentinfo where login.TypeName= 'student' AND login.status= 'active' AND login.UserID=studentinfo.UserID GROUP BY login.UserID;";
$resultMe = mysqli_query($db,$query);
while($row = mysqli_fetch_assoc($resultMe)) { 

$emaildecrypted=decryptthis($row["email"], $encryptionKey);
$ICdecrypted=decryptthis($row["IC"], $encryptionKey);
$Numdecrypted=decryptthis($row["PhoneNum"], $encryptionKey);?>

<td align="center"><?php echo $row["FullName"]; ?></td>
<td align="center"><?php echo $row["UserID"]; ?></td>
<td align="center"><?php echo $emaildecrypted; ?></td>
<td align="center"><?php echo $ICdecrypted; ?></td>
<td align="center"><?php echo $Numdecrypted; ?></td>
<td align="center"><?php echo $row["gender"]; ?></td>
<td align="center"><a href="editStudent.php?UserID=<?php echo $row["UserID"]; ?>">Edit</a></td>
<td align="center"><a href="activateUser.php?UserID=<?php echo $row["UserID"]; ?>">Active</a></td>
</tr>
<?php $count++; } ?>
</tbody>
</table>
<div class="right">
  <br>
  <a class="active" href="inactiveStudent.php">Previous Student</a>
</div>
<br>
<br>
<br>
</body>
</html>