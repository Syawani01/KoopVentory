<?php 
require 'functions.php'; 

if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php'); 
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['UserID']);
    header("location: login.php");
}

$query ="select ProductName from product";
$result = $db->query($query);
if($result->num_rows> 0){
    $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if (isset($_POST["add"])) {
  global $db, $username, $errors;

  $name = e($_POST['Name']);
  $code = e($_POST['barcode']);
  $expired = e($_POST['expired']);
  $quan = e($_POST['quantity']);
  $date_in = e($_POST['in']);

  if($name=='Select Product'){
    if(empty($code)){
      echo '<script>alert ("Please enter Product nama or code");window.location.href = "addStock(S).php";</script>';
    }else{
      $mysqli_page = $db->query("select * from probar where ProductCode  ='$code'");
      $Product= $mysqli_page->fetch_array(MYSQLI_ASSOC);
      $proID = $Product['ProductID'];
      $mysqli_page = $db->query("select * from stock where ProductID  ='$proID'");
      if ($mysqli_page->num_rows > 0){
        $stock = $mysqli_page->fetch_array(MYSQLI_ASSOC);
        $newQuan= $stock['quantity'] + $quan;
        $get_banner="update stock set quantity=?, expired=?, date_In=?  where ProductID=?";
        $run_banners = query($get_banner,[$newQuan,$expired,$date_in, $stock['ProductID']]);
        if ($run_banners) {
          echo '<script>alert ("Successfully add '.$name.'stock");window.location.href = "Inventory(S).php";</script>';
        }else {
          echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory(S).php";</script>';
        }
      }
    }
  }else{
    $mysqli_page = $db->query("select * from product where ProductName  ='$name'");
    $Product= $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $proID = $Product['ProductID'];

    $mysqli_page = $db->query("select * from stock where ProductID  ='$proID'");
    if ($mysqli_page->num_rows > 0){
      $stock = $mysqli_page->fetch_array(MYSQLI_ASSOC);
      $newQuan= $stock['quantity'] + $quan;
      $get_banner="update stock set quantity=?, expired=?, date_In=?  where ProductID=?";
      $run_banners = query($get_banner,[$newQuan,$expired,$date_in, $stock['ProductID']]);
      if ($run_banners) {
        echo '<script>alert ("Successfully add stock");window.location.href = "Inventory(S).php";</script>';
      }else {
        echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory(S).php";</script>';
      }
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
      <div class="logo"><a href="Inventory.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : Add Stock</b></h1></a>
    </div>
</nav>
<div class="header-right">
  <br>
  <a class="active" href="Inventory(S).php">Back</a>
  <p>* Please select Product Name or input Product Code</p>
</div>

<div style="width:75%;margin:0 auto">
    <form method="post" >
    <label>Product Name</label>
    <select name="Name">
      <option>Select Product</option>
      <?php 
      foreach ($options as $option) {
        ?>
        <option><?php echo $option['ProductName']; ?> </option>
        <?php 
      }
      ?>
    </select>
    <br>
    <br>
    <label>Product Code</label>
    <input type="text" name="barcode" class="form-control" placeholder="Bar code read" href="#barcode">
    <br>
    <label>Expired Date *for food only*</label>
    <br>
    <input type="date" name="expired" class="form-input">
    <br>
    <br>
    <label>Quantity Stock</label>
    <input type="text" name="quantity" class="form-input"  required>
    <br>
    <br>
    <label>Date stock in</label>
    <br>
    <input type="date" name="in" class="form-input" required>
    <br>
    <input type="submit" value="Add" class="btnTable" name="add"><br>
    <br>
  
    </form>
    <br>
</div>