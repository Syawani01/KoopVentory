<?php 
include('functions.php');

if($_SESSION['user']['TypeName'] == 'teacher'){
  require 'headerT.php';
}else if($_SESSION['user']['TypeName'] == 'admin'){
  require 'headerA.php';
}

$year = date('Y');
$month = date('m');

$connect = mysqli_connect("localhost", "root", "", "school_inventory");  
$query = "select product.ProductName AS 'Product Name', productinfo.BuyPrice AS 'Cost per item (Rm)', SUM(purchasedetail.noItem) AS 'Total sold', productinfo.SellPrice-productinfo.BuyPrice 
          AS 'Profit per Item (Rm)', (productinfo.SellPrice-productinfo.BuyPrice)*SUM(purchasedetail.noItem) AS 'Total income (Rm)', SUM(purchasedetail.noItem)*productinfo.SellPrice AS 'Total revenue (Rm)' 
          from product join productinfo join purchase join purchasedetail where product.ProductID=purchasedetail.ProductID AND purchasedetail.Purchase_D_ID=purchase.Purchase_D_ID AND product.ProductID=productinfo.ProductID
          AND Month(purchase.PurchaseDate)= '$month' AND Year(purchase.PurchaseDate) = '$year' GROUP BY purchasedetail.ProductID;";  
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
      title: 'Percentage of revenue of each product sold this month',  
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

form {
	width: 30%;
	margin: 0px auto;
	padding: 20px;
	border: 4px solid darkcyan;
	background: white;
	border-radius: 0px 0px 10px 10px;
  float: left;
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
<h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp REPORT</h2>

<form action="DailySales.php" method="post" id="nameform">
  <label> Daily Sales :</label>
  <br>
  <input type="date" name="date" class="form-input">
  <input type="submit" name="search" value="Search">
</form>

<form action="MonthlySales.php" method="POST">
  <label> Monthly Sales :</label>
  <br>
  <select name="month" value=''>Select Month</option>
    <option value='01'>January</option>
    <option value='02'>February</option>
    <option value='03'>March</option>
    <option value='04'>April</option>
    <option value='05'>May</option>
    <option value='06'>June</option>
    <option value='07'>July</option>
    <option value='08'>August</option>
    <option value='09'>September</option>
    <option value='10'>October</option>
    <option value='11'>November</option>
    <option value='12'>December</option>
  </select>
  <select name="year">
  <option>Select Year</option>
  <?php foreach($years as $year) : ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
  <?php endforeach; ?>
</select>
  <input type="submit" name="search" value="Search">
</form>
<br>
<br>
<br>
<br>
<br>
<h3>&nbsp &nbsp &nbsp &nbsp &nbsp This Month Revenue</h3>
<div id="piechart" style="width: 900px; height: 500px;"></div>

</body>
</html>