<?php
require 'functions.php';

if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php'); 
}

if(empty($_SESSION["cart_item"])) {
  echo '<script>alert ("The chart is empty");window.location.href = "POS(S).php";</script>';
}else{
  $date = $_POST['date'];
  $total = $_POST['total'];
  $cash = $_POST['cash'];
  $emp = $_POST['employee'];
  //imma make it trans uniq id
  $today = date("mdGis"); 

  if($cash=='0'){
    $balance=$cash;
  }else{
    $balance= $cash - $total;
  }

  $countID = count($_POST['name']);
      // echo "<table>";
      $semua='0';
      for($i=1; $i<=$countID; $i++){
        $quantity= $_POST['quantity'][$i-1];
        $semua= $semua + $quantity;
      }
      $get_banner="insert into purchase(Purchase_D_ID, Quantity, PurchaseDate, TotalPrice, PayType, UserID) 
      VALUES (?,?,?,?,?,?)";
      $run_banners = query($get_banner,["PCH".$today, $semua, $date, $total, "Cash", $emp]);

    for($i=1; $i<=$countID; $i++){
      // echo "'{$today}', '".$_POST['name'][$i-1]."', '".$_POST['quantity'][$i-1]."', '".$_POST['price'][$i-1]."', '{$emp}', '{$rol}' <br>";
      $name= $_POST['name'][$i-1];
      $mysqli_page = $db->query("select * from product where ProductName  ='$name'");
      $ID = $mysqli_page->fetch_array(MYSQLI_ASSOC);
      $proID = $ID['ProductID'];

      $get_banner="insert into purchasedetail(Purchase_D_ID, ProductID, noItem, Price) 
        VALUES (?,?,?,?)";
      $run_banners = query($get_banner,["PCH".$today, $proID, $_POST['quantity'][$i-1], $_POST['price'][$i-1]]);
      
      $mysqli_page = $db->query("select * from stock where ProductID  ='$proID'");
      $stock = $mysqli_page->fetch_array(MYSQLI_ASSOC);
      $newQuan= $stock['quantity'] - $_POST['quantity'][$i-1];
      $get_banner="update stock set quantity=? where ProductID=?";
      $run_banners = query($get_banner,[$newQuan, $proID]); 
    }
    unset($_SESSION['pointofsale']);
    unset($_SESSION["cart_item"]);

  echo '<script>alert ("Successfull Payment. Balance : RM '.$balance.'");window.location.href = "POS(S).php";</script>';
  }
?>
  
</div>
