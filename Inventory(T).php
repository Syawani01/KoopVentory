<?php 
include('functions.php');
require 'headerT.php';

if (!isLoggedIn()) {
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

.header-right {
  float: right;
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

.right a.active {
  background-color: cadetblue;
  color: black;
  padding: 7px 10px;
}

.right {
  float: right;
  padding: 5px 5px;
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
<h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp INVENTORY</h2>
<table style="margin:0 auto; width:85%; background-color:cadetblue">
    <tr>
        <th style="width:30%">List of Product </th>
    </tr>
</table>


<table style="margin:0 auto;width:85%;text-align:center;">
<thead>
<tr>
<th><strong>Product Name</strong></th>
<th><strong>Product ID</strong></th>
<th><strong>Product Bar Code</strong></th>
<th><strong>Sell Price</strong></th>
<th><strong>Buy Price</strong></th>
<th><strong>Product Category</strong></th>
<th><strong>Min Stock Level</strong></th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$query="SELECT product.ProductID, product.ProductName, probar.ProductCode, productinfo.SellPrice, productinfo.BuyPrice, productinfo.Categoryname, productinfo.lowLevel 
        from product join productinfo join probar where product.ProductID=productinfo.ProductID AND product.status= 'active' AND product.ProductID=probar.ProductID; ";
$resultMe = mysqli_query($db,$query);
while($row = mysqli_fetch_assoc($resultMe)) { ?>
<td align="center"><?php echo $row["ProductName"]; ?></td>
<td align="center"><?php echo $row["ProductID"]; ?></td>
<td align="center"><?php echo $row["ProductCode"]; ?></td>
<td align="center">Rm <?php echo $row["SellPrice"]; ?></td>
<td align="center">Rm <?php echo $row["BuyPrice"]; ?></td>
<td align="center"><?php echo $row["Categoryname"]; ?></td>
<td align="center"><?php echo $row["lowLevel"]; ?></td>
</tr>

<?php $count++; } ?>
</tbody>
</table>
<br>
<br>
<br>
<table style="margin:0 auto; width:85%; background-color:cadetblue">
    <tr>
        <th style="width:30%">List of Stock</th>
    </tr>
</table>
<div style="width:100%;text-align:center;">
    <div class="add">
        <h2><b><a href="AddStock.php">Add Stock</a></b></h2>
    </div>
</div>
<table style="margin:0 auto;width:85%;text-align:center;">
<thead>
<tr>
<th><strong>Product Name</strong></th>
<th><strong>Product Bar Code</strong></th>
<th><strong>Quantity</strong></th>
<th><strong>Expired Date</strong></th>
<th><strong>Date In Stock</strong></th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$query="select product.ProductName, probar.ProductCode, stock.quantity, stock.expired, stock.date_In from stock join product join probar where stock.ProductID=product.ProductID 
        AND product.status='active' AND product.ProductID=probar.ProductID; ";
$resultMe = mysqli_query($db,$query);
while($row = mysqli_fetch_assoc($resultMe)) { ?>
<tr>
<td align="center"><?php echo $row["ProductName"]; ?></td>
<td align="center"><?php echo $row["ProductCode"]; ?></td>
<td align="center"><?php echo $row["quantity"]; ?></td>
<td align="center"><?php echo $row["expired"]; ?></td>
<td align="center"><?php echo $row["date_In"]; ?></td>
</tr>

<?php $count++; } ?>
</tbody>
</table>

<br>
</body>
</html>