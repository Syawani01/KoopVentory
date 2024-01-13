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

$ProductID = $_GET['ProductID'];
$mysqli_page = $db->query("SELECT substring_index(substring_index(Details, ';', 1), ':', -1) AS 'Name', 
                    substring_index(substring_index(Details, ';', 2), ':', -1) AS 'SellPrice', 
                    substring_index(substring_index(Details, ';', 3), ':', -1) AS 'BuyPrice', 
                    substring_index(substring_index(Details, ';', 4), ':', -1) AS 'Category', 
                    substring_index(substring_index(Details, ';', 5), ':', -1) AS 'low', 
                    DateTime from editproduct where ProductID= '$ProductID' And DateTime IN (SELECT max(DateTime) FROM editproduct);");

//THE KEY FOR ENCRYPTION AND DECRYPTION
$encryptionKey = base64_encode(32);

if ($mysqli_page->num_rows > 0){
    $row_page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $name = $row_page['Name'];
    $sell = $row_page['SellPrice'];
    $buy = $row_page['BuyPrice'];
    $cate = $row_page['Category'];
    $low = $row_page['low'];
    $time = $row_page['DateTime'];

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $curDate = date("Y-m-d H:i:s ");
    $date1 = new DateTime($time);
    $date2 = new DateTime($curDate);
    $diff = $date2->diff($date1);
    $hours = $diff->h;
    $hours = $hours + ($diff->days*24);
    if($hours > 24){
      $get_banner="delete FROM editproduct where ProductID=?";
      $run_banners = query($get_banner,[$ProductID]);
      echo '<script>alert ("Previous data already expired");window.location.href = "Inventory.php";</script>';
    }

}else{
    echo '<script>alert ("No Edit data");window.location.href = "Inventory.php";</script>';
}


if(isset($_POST["Restore"])){
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $time = date("Y-m-d H:i:s ");
    $mysqli_page = $db->query("SELECT Details FROM editproduct WHERE ProductID='$ProductID' AND DateTime IN (SELECT max(DateTime) FROM editproduct);");
    $page = $mysqli_page->fetch_array(MYSQLI_ASSOC);
    $details = $page['Details'];

    $get_banner="update productinfo set SellPrice=?, BuyPrice=?, Categoryname=?, lowLEvel=? where ProductID=?";
    $run_banners = query($get_banner,[$sell,$buy,$cate,$low,$ProductID]);

    $get_banner="update product set ProductName=? where ProductID=?";
    $run_banners = query($get_banner,[$name,$ProductID]);

    $get_banner="insert into rollbackproduct(After, ProductID, Datetime, Details) 
    VALUES (?,?,?,?)";
    $run_banners = query($get_banner,["Edit", $ProductID, $time, $details]);

    $get_banner="delete FROM editproduct where ProductID=?";
    $run_banners = query($get_banner,[$ProductID]);

    if($run_banners){
      echo '<script>alert ("Successfully Restore");window.location.href = "Inventory.php";</script>';
            
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
      <a href="#" class=""  ><h1><b>KoopVentory : Previous Student Data</b></h1></a>
    </div>
  
</nav>

<div class="header-right">
  <br>
  <a class="active" href="editProduct.php?ProductID=<?php echo $ProductID; ?>">Back</a>
</div>

<div style="width:75%;margin:0 auto">
    <br>
    <br>
    <form method="post" >
    <label>Product Name</label>
    <input type="text" name="name" class="form-input"  value="<?= $name?>" disabled required>
    <br>
    <br>
    <label>Sell Price</label>
    <input type="text" name="Sell" class="form-input"  value="<?= $sell?>" disabled required>
    <br>
    <br>
    <label>Buy Price</label>
    <input type="text" name="Buy" class="form-input" value="<?= $buy?>" disabled required>
    <br>
    <br>
    <label>Category</label>
    <input type="text" name="cate" class="form-input" value="<?= $cate?>" disabled required>
    <br>
    <br>
    <label>Low Level</label>
    <input type="text" name="level" class="form-input" value="<?= $low?>" disabled required>
    <br>
    <input type="submit" value="Restore Data" class="btnTable" name="Restore"><br>
    <br>
    </form>
    <br>
    
</div>