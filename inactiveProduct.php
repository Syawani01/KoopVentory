<?php 
require 'functions.php';

if (!isTeacAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
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
    width: 100%;
}

.tr a:hover{
    background-color:darkgreen;
    transition:0.4s;
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
      <a href="#" class=""  ><h1><b>KoopVentory : Inactive Product</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="Inventory.php">Back</a>
</div>
<br>
<table style="margin:0 auto; width:85%; background-color:cadetblue">
    <tr>
        <th style="width:30%">List of Previous Product</th>
    </tr>
</table>

<form action="Inventory.php" method="post">
<table style="margin:0 auto;width:85%;text-align:center;">
    <thead>
        <tr>
            <th><strong>Product Name</strong></th>
            <th><strong>Product ID</strong></th>
            <th><strong>Product Code</strong></th>
            <th><strong>Sell Price</strong></th>
            <th><strong>Buy Price</strong></th>
            <th><strong>Product Category</strong></th>
            <th><strong>Min Stock Level</strong></th>
            <th><strong>Activate</strong></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $count=1;
    $query="SELECT product.ProductID, product.ProductName, probar.ProductCode, productinfo.SellPrice, productinfo.BuyPrice, productinfo.Categoryname, productinfo.lowLevel 
    from product join productinfo join probar where product.ProductID=productinfo.ProductID AND product.status= 'inactive' AND product.ProductID=probar.ProductID;";
    $resultMe = mysqli_query($db,$query);
    while($row = mysqli_fetch_assoc($resultMe)) { ?>
        <tr>
        <td align="center"><?php echo $row["ProductName"]; ?></td>
        <td align="center"><?php echo $row["ProductID"]; ?></td>
        <td align="center"><?php echo $row["ProductCode"]; ?></td>
        <td align="center"><?php echo $row["SellPrice"]; ?></td>
        <td align="center"><?php echo $row["BuyPrice"]; ?></td>
        <td align="center"><?php echo $row["Categoryname"]; ?></td>
        <td align="center"><?php echo $row["lowLevel"]; ?></td>
        <td align="center"><input type="hidden" value="<?php echo $row["ProductID"]; ?>" name="id"/>
        <input name="pro" type="submit" value="<?php echo $row["ProductID"]; ?>">&nbsp;</center></td>
        </tr>
        </tr>
        <?php } ?>
    <?php $count++; ?> 


</tbody>
</table>
</form>