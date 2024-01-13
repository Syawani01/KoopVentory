<!DOCTYPE html>
<html>
<head>
<nav style="justify-content: space-between;align-items:center">
  
    <div class="header">
      <br>
      <div class="logo"><a href="TeacherDashv2.php"><img src="images/schoolLogo.jpg" height="100" width="100"></a></div>
      <a href="#" class=""  ><h1><b>KoopVentory : Teacher</b></h1></a>
      <div class="header-right">
        <br>
        <a class="active" href="POS.php">POS</a>
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