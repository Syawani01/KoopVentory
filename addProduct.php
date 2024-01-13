<?php 
include('functions.php');


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['UserID']);
    header("location: login.php");
}

if (isset($_POST["add"])) {
  global $db, $username, $errors;

  $query="select max(ProductID) AS 'max' from product";
    $resultMe = mysqli_query($db,$query); 
    $row = mysqli_fetch_assoc($resultMe);
    $ID=$row["max"];
    $letter = $ID[0].$ID[1].$ID[2];
    $number = $ID[3].$ID[4].$ID[5].$ID[6];
    $newProduct=e($letter.sprintf("%03d", $number+1));

  $name = e($_POST['Name']);
  $buy = e($_POST['BuyPrice']);
  $buy = number_format($buy, 2);
  $sell = e($_POST['SellPrice']);
  $sell = number_format($sell, 2);
  $cate = e($_POST['category']);
  $level = e($_POST['Level']);
  $code = e($_POST['barcode']);
  $num = e($_POST['num']);
  $status="active";

  $get_banner="insert into product(ProductID, ProductName, status) 
  VALUES (?,?,?)";
  $run_banners = query($get_banner,[$newProduct,$name,$status]);
  if(empty($code)){
      $code = mt_rand(1000000000,9999999999);
      $get_banner="insert into productinfo(ProductID, SellPrice, BuyPrice, Categoryname, lowLevel) 
      VALUES (?,?,?,?,?)";
      $run_banners = query($get_banner,[$newProduct, $sell, $buy, $cate, $level]);
      
      $get_banner="insert into stock(ProductID, quantity) 
      VALUES (?,?)";
      $run_banners = query($get_banner,[$newProduct, $num]);

      $get_banner="insert into probar(ProductID, ProductCode) 
      VALUES (?,?)";
      $run_banners = query($get_banner,[$newProduct, $code]);
      if ($run_banners) {
        echo '<script>alert ("Successfully add product");window.location.href = "Inventory.php";</script>';
      } else {
          echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory.php";</script>';
      }
  }else{
      $get_banner="insert into probar(ProductID, ProductCode) 
      VALUES (?,?)";
      $run_banners = query($get_banner,[$newProduct, $code]);

      $get_banner="insert into productinfo(ProductID, SellPrice, BuyPrice, Categoryname, lowLevel) 
      VALUES (?,?,?,?,?)";
      $run_banners = query($get_banner,[$newProduct, $sell, $buy, $cate, $level]);
      
      $get_banner="insert into stock(ProductID, quantity) 
      VALUES (?,?)";
      $run_banners = query($get_banner,[$newProduct, $num]);
      if ($run_banners) {
        echo '<script>alert ("Successfully add product");window.location.href = "Inventory.php";</script>';
      } else {
          echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory.php";</script>';
      }
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
    width:120px;
    display:block;
    padding:10px;
    font-size:17px;
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

a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
  
}

.previous {
  background-color: #f1f1f1;
  color: black;
  border: 1px solid black;
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
      <div class="logo"><a href="Inventory.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : Add Product</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="Inventory.php">Back</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <form method="post" >
    <input type="hidden" name="num" value="0">
    <label>Product Name *</label>
    <input type="text" name="Name" class="form-input"  required>
    <br>
    <br>
    <label>Product Bar Code</label>
    <input type="text" name="barcode" class="form-control" placeholder="Bar code read" href="#barcode">
    <br>
    <br>
    <label>Sell Price *</label>
    <input type="text" name="SellPrice" class="form-input"  required>
    <br>
    <br>
    <label>Buy Price *</label>
    <input type="text" name="BuyPrice" class="form-input"  required>
    <br>
    <br>
    <label>Min Stock Level *</label>
    <input type="text" name="Level" class="form-input"  required>
    <br>
    <br>
    <label>Category Name *</label>
    <select name="category" id="category" class="form-input" required>
      <option value="">Please Select</option>
      <option value="Book/Paper">Book/Paper</option>
      <option value="Cloth">Cloth</option>
      <option value="Food">Food</option>
      <option value="Stationary">Stationary</option>
    </select>
    <br>
    <br>
    <input type="submit" value="Add" class="btnTable" name="add"><br>
    <br>
  
    </form>
    <br>
</div>