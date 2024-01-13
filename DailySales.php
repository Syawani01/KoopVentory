<?php 
include('functions.php');

$date = $_POST['date'];
$income = 0;

$connect = mysqli_connect("localhost", "root", "", "school_inventory");  
$query = "select product.ProductName AS 'Product Name', productinfo.BuyPrice AS 'Cost per item (Rm)', SUM(purchasedetail.noItem) AS 'Total sold', productinfo.SellPrice-productinfo.BuyPrice AS 'Profit per Item (Rm)', 
          (productinfo.SellPrice-productinfo.BuyPrice)*SUM(purchasedetail.noItem) AS 'Total income (Rm)', SUM(purchasedetail.noItem)*productinfo.SellPrice AS 'Total revenue (Rm)' from product join productinfo 
          join purchase join purchasedetail where product.ProductID=purchasedetail.ProductID AND purchasedetail.Purchase_D_ID=purchase.Purchase_D_ID AND product.ProductID=productinfo.ProductID 
          AND purchase.PurchaseDate= '$date' GROUP BY purchasedetail.ProductID;";  
$result = mysqli_query($connect, $query);

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

$years = range(2020, strftime("%Y", time()));
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<script type="text/javascript">  
  google.charts.load('current', {'packages':['corechart']});  
  google.charts.setOnLoadCallback(drawChart);  
  function drawChart()  {  
    var data = google.visualization.arrayToDataTable([  
        ['Product', 'Number'],  
        <?php  
        while($row = mysqli_fetch_array($result))  {  
            echo "['".$row["Product Name"]."', ".$row["Total revenue (Rm)"]."],";  
        }  
        ?>  
    ]);  
    var options = {  
      title: 'Percentage of revenue of each product sold this day',  
      //is3D:true,  
      pieHole: 0.4  
    };  
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
    chart.draw(data, options);  
  }  
</script>  
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
</style>
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
      <a href="#" class=""  ><h1><b>KoopVentory : Daily Sales</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="Report.php">Back</a>
</div>
<br>
<form>
    <h3>Date : <?php echo $date ?></h3>
<table style="margin:0 auto;width:85%;text-align:center;">
<thead>
<tr>
<th><strong>Product Name</strong></th>
<th><strong>Cost per Item</strong></th>
<th><strong>Total Sold</strong></th>
<th><strong>Profit per item</strong></th>
<th><strong>Total income per item</strong></th>
<th><strong>Total revenur</strong></th>
</tr>
</thead>
<tbody>
<?php
$count=1;
$query="select product.ProductName AS 'Product Name', productinfo.BuyPrice AS 'Cost per item (Rm)', SUM(purchasedetail.noItem) AS 'Total sold', productinfo.SellPrice-productinfo.BuyPrice AS 'Profit per Item (Rm)', 
        (productinfo.SellPrice-productinfo.BuyPrice)*SUM(purchasedetail.noItem) AS 'Total income (Rm)', SUM(purchasedetail.noItem)*productinfo.SellPrice AS 'Total revenue (Rm)' from product join productinfo join purchase 
        join purchasedetail where product.ProductID=purchasedetail.ProductID AND purchasedetail.Purchase_D_ID=purchase.Purchase_D_ID AND product.ProductID=productinfo.ProductID AND purchase.PurchaseDate= '$date' 
        GROUP BY purchasedetail.ProductID;";
$resultMe = mysqli_query($db,$query);
while($row = mysqli_fetch_assoc($resultMe)) { 
    $now = $row["Total income (Rm)"]; ?>
<td align="center"><?php echo $row["Product Name"]; ?></td>
<td align="center">Rm <?php echo $row["Cost per item (Rm)"]; ?></td>
<td align="center"><?php echo $row["Total sold"]; ?></td>
<td align="center">Rm <?php echo $row["Profit per Item (Rm)"]; ?></td>
<td align="center">Rm <?php echo $row["Total income (Rm)"]; ?></td>
<td align="center">Rm<?php echo $row["Total revenue (Rm)"]; ?></td>
</tr>
<?php 
$income = $income + $now;
$count++; } ?>
</tbody>
</table>
<h4>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total daily income : Rm <?php echo $income ?></h4>
<h3>&nbsp &nbsp &nbsp &nbsp &nbsp Daily Revenue</h3>
<div id="piechart" style="width: 900px; height: 500px;"></div>
</form>