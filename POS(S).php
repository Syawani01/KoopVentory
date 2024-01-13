<?php
require_once("dbcontroller.php");
include('functions.php');
$db_handle = new DBController();

if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php'); 
}

$tab_result = $db_handle->runQuery("SELECT Categoryname FROM productinfo GROUP BY Categoryname");
$tab_menu = '';
$tab_content = '';
$i = 0;

$UserID = $_SESSION['user']['UserID'];

$today = date("Y-m-d H:i a"); 
$to = date("mdGis"); 
$use = $_SESSION['user']['FullName'];

foreach($tab_result as $key=>$value){
	if($i == 0){
  	$tab_menu .= '
   	<li class="active"><a href="#'.$tab_result[$key]["Categoryname"].'" data-toggle="tab">'.$tab_result[$key]["Categoryname"].'</a></li>
  	';
  	$tab_content .= '
   	<div id="'.$tab_result[$key]["Categoryname"].'" class="tab-pane fade in active">
  	';
 	}else{
  	$tab_menu .= '
   	<li><a href="#'.$tab_result[$key]["Categoryname"].'" data-toggle="tab">'.$tab_result[$key]["Categoryname"].'</a></li>
  	';
  	$tab_content .= '
   	<div id="'.$tab_result[$key]["Categoryname"].'" class="tab-pane fade">
  	';
 	}

	$sub_row = $db_handle->runQuery("SELECT product.ProductName,  probar.ProductCode, productinfo.*, stock.quantity FROM product JOIN productinfo join stock join probar WHERE productinfo.Categoryname = '".$tab_result[$key]["Categoryname"]."' AND product.ProductID=productinfo.ProductID AND product.ProductID=stock.ProductID AND product.ProductID=probar.ProductID;");
	foreach($sub_row as $key=>$value)
 	{
  	$tab_content .= '
  	<div class="col-md-3" style="margin-bottom:36px;">
  	<form method="post" action="POS(S).php?action=add&id='.$sub_row[$key]["ProductID"].' ">
    <h6>Code : '.$sub_row[$key]["ProductCode"].'</h6>
    <h6>Name : '.$sub_row[$key]["ProductName"].'</h6>
    <h6>Price : Rm'.$sub_row[$key]["SellPrice"].'</h6>
    <h6>Stock : '.$sub_row[$key]["quantity"].'</h6>
    <input type="hidden" name="code" value='.$sub_row[$key]["ProductCode"].' />
    <input type="hidden" name="name" value='.$sub_row[$key]["ProductName"].' />
    <input type="hidden" name="price" value='.$sub_row[$key]["SellPrice"].' />
    <input type="hidden" name="stock" value='.$sub_row[$key]["quantity"].' />
    <input type="text" name="quantity" class="form-control" value="1" />
    <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info" value="Add" />
  	</form>
  	</div>
  	';
 	}
 	$tab_content .= '<div style="clear:both"></div></div>';
 	$i++;
}

if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
    $quan=$_POST['quantity'];
    $st=$_POST['stock'];

    if($quan>$st){
      echo '<script>alert ("Not enough stock for this quantity");window.location.href = "POS.php";</script>';
    }
    else{
		  if(!empty($_POST["quantity"])) {
			  $productByCode = $db_handle->runQuery("SELECT product.ProductName, probar.ProductCode, productinfo.SellPrice FROM product join productinfo join probar WHERE probar.ProductCode='" . $_POST["code"] . "' AND product.ProductID=productinfo.ProductID AND product.ProductID=probar.ProductID");
			  $itemArray = array($productByCode[0]["ProductCode"]=>array('name'=>$productByCode[0]["ProductName"], 'code'=>$productByCode[0]["ProductCode"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["SellPrice"]));
			
			  if(!empty($_SESSION["cart_item"])) {
				  if(in_array($productByCode[0]["ProductCode"],array_keys($_SESSION["cart_item"]))) {
					  foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["ProductCode"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					  }
				  } else {
					  $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
          }
        } else {
				$_SESSION["cart_item"] = $itemArray;
			  }
      }
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
  }
}

if(isset($_POST['add'])){
    $productByCode = $db_handle->runQuery("SELECT product.ProductName, probar.ProductCode*, productinfo.SellPrice FROM product join productinfo join probar  WHERE product.ProductCode='" . $_POST["bar"] . "' AND product.ProductID=productinfo.ProductID product.ProductID=probar.ProductID");
		$itemArray = array($productByCode[0]["ProductCode"]=>array('name'=>$productByCode[0]["ProductName"], 'code'=>$productByCode[0]["ProductCode"], 'quantity'=>$_POST["num"], 'price'=>$productByCode[0]["SellPrice"]));
			
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($productByCode[0]["ProductCode"],array_keys($_SESSION["cart_item"]))) {
				foreach($_SESSION["cart_item"] as $k => $v) {
					if($productByCode[0]["ProductCode"] == $k) {
						if(empty($_SESSION["cart_item"][$k]["quantity"])) {
							$_SESSION["cart_item"][$k]["quantity"] = 0;
						}
							$_SESSION["cart_item"][$k]["quantity"] += $_POST["num"];
					}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
}

?>
<HTML>
<HEAD>
<TITLE>KoopVentory</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
<link href="style3.css" type="text/css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
	table, th, td {
  	border: 1px solid black;
  	border-collapse: collapse;
  	padding: 10px 10px 10px 10px;
	}

  hr{
  border: 1px solid black;
  }


  </style>
</HEAD>
<BODY>
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
        <br>
        <div class="logo"><a href="StudDash.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
        <a href="#" class=""  ><h1><b>KoopVentory : Point-Of-Sale</b></h1></a>
        <div class="header-right">
            <br>
            <a class="active" href="Inventory(S).php">Inventory</a>
        </div>
    </div>
</nav>
<br>
<ul class="nav nav-tabs">
   <?php
   echo $tab_menu;
   ?>
</ul>
<div class="tab-content">
   <br />
   <?php
   echo $tab_content;?>
</div>

<form method="post" action="">
  <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Barcode :</label>
  <input type="text" name="bar" class="form-input" required>
  <label>Quantity :</label>
  <input type="text" name="num" class="form-input" value="1" required>
  <input type="submit" name="add" value="Add">
</form>

<div id="shopping-cart" style="margin:0 auto;width:85%;text-align:center;border: 1px solid black;">
<div class="txt-heading" style="text-align:left; font-size:18px; padding: 7px 10px;">&nbsp &nbsp &nbsp POS Cart</div>
<a id="btnEmpty" href="POS(S).php?action=empty">Empty Cart </a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<br>
<form role="form" method="post" action="pos_transac(S).php">
<input type="hidden" name="employee" value="<?php echo $UserID ?>">
<input type="hidden" name="date" value="<?php echo $today; ?>">

<h5 style="text-align:left; font-size:15px">&nbsp &nbsp &nbsp Date        : <?php echo $today; ?></h5>
<h5 style="text-align:left; font-size:15px">&nbsp &nbsp &nbsp Staff       : <?php echo $use ?></h5>
<br>
<table style="margin:0 auto;width:85%;text-align:center;border: 1px solid black;" class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:center; font-size:18px" width="15%">Name</th>
<th style="text-align:center; font-size:18px" width="15%">Code</th>
<th style="text-align:center; font-size:18px" width="5%">Quantity</th>
<th style="text-align:center; font-size:18px" width="10%">Unit Price</th>
<th style="text-align:center; font-size:18px" width="10%">Price</th>
<th style="text-align:center; font-size:18px" width="10%">Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td style="text-align:center; font-size:15px">
          <input type="hidden" name="name[]" value="<?php echo $item["name"]; ?>">
          <?php echo $item["name"]; ?>
        </td>
				<td style="text-align:center; font-size:15px">
          <input type="hidden" name="code[]" value="<?php echo $item["code"]; ?>">
          <?php echo $item["code"]; ?>
        </td>
				<td style="text-align:center; font-size:15px">
          <input type="hidden" name="quantity[]" value="<?php echo $item["quantity"]; ?>">
          <?php echo $item["quantity"]; ?>
        </td>
				<td  style="text-align:center; font-size:15px">
          <input type="hidden" name="price[]" value="<?php echo $item["price"]; ?>">
          <?php echo "Rm ".$item["price"]; ?>
        </td>
				<td  style="text-align:center; font-size:15px">
          <?php echo "Rm ". number_format($item_price,2); ?>
        </td>
				<td style="text-align:center;"><a href="POS(S).php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>


<tr>	
<td colspan="2" align="right" style="font-size:18px"><strong>Total:</strong></td>
<td align="center" style="font-size:18px"><strong><?php echo $total_quantity; ?></strong></td>
<td align="center" colspan="2" style="font-size:18px"><strong><?php echo "Rm ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
<br>		
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
<label style="text-align:left; font-size:15px">&nbsp &nbsp &nbsp Payment Type :</label>
&nbsp &nbsp &nbsp
<button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#cash">PAY</button>


<!-- Modal -->
<div class="modal fade" id="cash" tabindex="-1" role="dialog" aria-labelledby="POS" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">SUMMARY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="form-group row text-left mb-2">

                    <div class="col-sm-12 text-center">
                      <h3 class="py-0">
                        GRAND TOTAL
                      </h3>
                      <?php if(empty($_SESSION["cart_item"])) { ?>
                          <h3 class="font-weight-bold py-3 bg-light">Chart is empty </h3>
                      <?php }else{ ?>
                      <h3 class="font-weight-bold py-3 bg-light">
                        <?php echo "Rm ".number_format($total_price, 2); ?>
                      </h3>
                      <h5>* If pay using card, enter 0</h5>
                      <input type="hidden" name="total" value="<?php echo number_format($total_price, 2); ?>">
                      <?php } ?>
                    </div>

                  </div>

                    <div class="col-sm-12 mb-2">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rm</span>
                        </div>
                          <input class="form-control text-right" id="txtNumber" onkeypress="return isNumberKey(event)" type="text" name="cash" placeholder="ENTER CASH" name="cash" required>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
              <a href="pos_transac.php"> 
                <button type="submit" name="duit" class="btn btn-primary btn-block">PROCEED TO PAYMENT</button>
              </div>
            </div>
          </div>
        </div>
        <!-- END OF Modal -->



<br>
<br>
</div>
<br>
</BODY>
</HTML>