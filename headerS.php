<!DOCTYPE html>
<html>
<head>
<nav style="justify-content: space-between;align-items:center">
  
    <div class="header">
      <br>
      <div class="logo"><a href="StudDash.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : Student</b></h1></a>
      <div class="header-right">
        <br>
        <a class="active" href="POS(S).php">POS</a>
        &nbsp;
        <a class="active" href="StudDash.php?logout='1">Logout</a>
      </div>
    </div>
    <?php
    $use = $_SESSION['user']['FullName'];
	  echo "<h3 class='text-success' style= float-right>&nbsp Welcome ".$use."</h3>";
    ?>
  
</nav>

</head>