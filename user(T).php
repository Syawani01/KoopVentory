<?php 
include('functions.php');
require 'headerT.php';

$date = date('Y-m-d');




if (!isTeacAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['UserID']);
    header("location: login.php");
}

$encryptionKey = base64_encode(32);

function decryptthis($data, $key) {
    // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
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
  padding: 0px 5px;
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
        </tr>
        <?php } ?>
    <?php $count++; ?> 


</tbody>
</table>


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
</tr>
</thead>
<tbody>
<?php
$count=1;
$query="select login.FullName, login.UserID, studentinfo.email, studentinfo.IC, studentinfo.PhoneNum, studentinfo.gender 
        from login join studentinfo where login.TypeName= 'student' AND login.status= 'active' AND login.UserID=studentinfo.UserID 
        GROUP BY login.UserID;";
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
</tr>
<?php $count++; } ?>
</tbody>
</table>
<br>
<br>
<br>
</body>
</html>