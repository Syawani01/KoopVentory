<?php 
include('functions.php');
require 'headerS.php';

if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php'); 
}


$date = date('Y-m-d');

$connect = mysqli_connect("localhost", "root", "", "school_inventory");  
$query = "select product.ProductName AS 'Product Name', productinfo.BuyPrice AS 'Cost per item (Rm)', SUM(purchasedetail.noItem) AS 'Total sold', productinfo.SellPrice-productinfo.BuyPrice AS 'Profit per Item (Rm)', (productinfo.SellPrice-productinfo.BuyPrice)*SUM(purchasedetail.noItem) AS 'Total income (Rm)', SUM(purchasedetail.noItem)*productinfo.SellPrice AS 'Total revenue (Rm)' from product join productinfo join purchase join purchasedetail where product.ProductID=productinfo.ProductID AND purchasedetail.Purchase_D_ID=purchase.Purchase_D_ID AND purchasedetail.ProductID=product.ProductID AND purchase.PurchaseDate= '$date' GROUP BY purchasedetail.ProductID;";  
$result = mysqli_query($connect, $query);


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['UserID']);
    header("location: login.php");
}
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
      title: 'Percentage of revenue of each product sold today',  
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

table {
  width: 50%;
  background-color: palevioletred;
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
    <li><a href="StudDash.php">Home</a></li>
        <li><a href="Inventory(S).php">Inventory</a></li>

    </ul>
</div>
<h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Stock Notification</h2>
<table style="width:30%;text-align:center">
    <tr>
        <th style="width:20%">Product Name</th>
        <th style="width:20%">Stock</th>
    </tr>
    <?php
    $mysqli_page = $db->query("select product.ProductName, stock.quantity from product join stock join productinfo where product.ProductID=stock.ProductID and stock.quantity<=productinfo.lowLevel AND product.ProductID=productinfo.ProductID;");
    $id;
    if ($mysqli_page->num_rows > 0){
        while($row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td>";
            echo $row_page['ProductName'];
            echo "</td><td>";
            echo $row_page['quantity'];
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>
<br>
<h3>&nbsp &nbsp &nbsp &nbsp &nbsp Today Revenue</h3>
<div id="piechart" style="width: 900px; height: 500px;"></div>

</body>
</html>