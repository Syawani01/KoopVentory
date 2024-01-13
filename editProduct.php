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

$ProductID = $_GET['ProductID'];
$mysqli_page = $db->query("SELECT product.*, productinfo.* FROM product join productinfo WHERE product.ProductID='$ProductID' AND product.ProductID=productinfo.ProductID");

if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $Name = $row_page['ProductName'];
    $sell = $row_page['SellPrice'];
    $buy = $row_page['BuyPrice'];
    $cate = $row_page['Categoryname'];
    $low = $row_page['lowLevel'];
}



if(isset($_POST["edit"])){
    $name = $_POST['Name'];
    $Sell = $_POST['Sell'];
    $Buy = $_POST['Buy'];
    $Cate = $_POST['category'];
    $level = $_POST['level'];
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $time = date("Y-m-d H:i:s ");;
    $data = "Name:".$Name.";"."SellPrice:".$sell.";"."BuyPrice:".$buy.";"."Category:".$cate.";"."MinLevel:".$low.";";

    $get_banner="update productinfo set SellPrice=?, BuyPrice=?, Categoryname=?, lowLevel=? where ProductID=?";
    $run_banners = query($get_banner,[$Sell,$Buy,$Cate,$level, $ProductID]);

    $get_banner="update product set ProductName=? where ProductID=?";
    $run_banners = query($get_banner,[$name, $ProductID]);

    $get_banner="insert into editProduct(DateTime, ProductID, Details) 
    VALUES (?,?,?)";
    $run_banners = query($get_banner,[$time,$ProductID,$data]);
        if($run_banners){
            echo '<script>alert ("Successfully Update");window.location.href = "Inventory.php";</script>';
            
        }else{
           echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory.php";</script>';
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
      <a href="#" class=""  ><h1><b>KoopVentory : Edit Product</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="Inventory.php">Back</a>
  <a class="active" href="ProductV1.php?ProductID=<?php echo $ProductID; ?>">Previous Version</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <label>Product Name</label>
    <input type="text" name="Name" class="form-input" placeholder="" value="<?= $Name?>" required>
    <br>
    <br>
    <label>Sell Price</label>
    <input type="text" name="Sell" class="form-input"  value="<?= $sell?>" required>
    <br>
    <br>
    <label>Buy Price</label>
    <input type="text" name="Buy" class="form-input" value="<?= $buy?>" required>
    <br>
    <br>
    <label>Category</label>
    <select name="category" id="category" class="form-input" value="<?= $cate?>" required>
        <option value="">Please Select</option>
        <option value="Book/Paper">Book/Paper</option>
        <option value="Cloth">Cloth</option>
        <option value="Food">Food</option>
        <option value="Stationary">Stationary</option>
    </select>
    <br>
    <br>
    <label>Low Level</label>
    <input type="text" name="level" class="form-input" value="<?= $low?>" required>
    <br>
    <input type="submit" value="Edit" class="btnTable" name="edit"><br>
    <br>
    </form>
    <br>
</div>