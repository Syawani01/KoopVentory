<?php 
include('functions.php');

if (!isTeacAdmin()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

$Purchase_D_ID = $_GET['Purchase_D_ID'];
$mysqli_page = $db->query("SELECT PurchaseDate, UserID, TotalPrice, PayType from purchase WHERE purchase.Purchase_D_ID='$Purchase_D_ID';");


if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $date = $row_page['PurchaseDate'];
    $user = $row_page['UserID'];
    $pay = $row_page['PayType'];
    $total = $row_page['TotalPrice'];
    
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

.header-right a.active {
  background-color: red;
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
      <div class="logo"><a href="Transaction.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : View Transaction</b></h1></a>
    </div>
  
</nav>


<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <h4>Date: <?php echo $date; ?></h4>
    <h4>Transaction :<?php echo $Purchase_D_ID; ?></h4>
    <h4>Staff: <?php echo $user; ?></h4>
    <hr>

    <table style="margin:0 auto;width:85%;text-align:center;">
    <thead>
        <tr>
            <th><strong>No</strong></th>
            <th><strong>Product Name</strong></th>
            <th><strong>No of Item</strong></th>
            <th><strong>Price per Item</strong></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count=1;
        $query="SELECT product.ProductName, purchasedetail.noItem, purchasedetail.Price FROM product join purchase join purchasedetail 
        WHERE product.ProductID=purchasedetail.ProductID and purchase.Purchase_D_ID=purchasedetail.Purchase_D_ID and purchase.Purchase_D_ID='$Purchase_D_ID';";
        $resultMe = mysqli_query($db,$query);
        while($row = mysqli_fetch_assoc($resultMe)) { ?>
            <tr>
                <td align="center"><?php echo $count; ?></td>
                <td align="center"><?php echo $row["ProductName"]; ?></td>
                <td align="center"><?php echo $row["noItem"]; ?></td>
                <td align="center">Rm <?php echo $row["Price"]; ?></td>
            </tr>
        <?php $count++; } ?>
    </tbody>
    </table>
    <hr>
    <h4>Payment Type: <?php echo $pay; ?></h4>
    <h4>Total: Rm <?php echo $total; ?></h4>
    <button type="submit" formaction="Transaction.php">Back</button>
    </form>
    <br>
</div>