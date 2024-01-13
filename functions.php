<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'school_inventory');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 


// return user array from their id
function getUserById($id){
    global $db;
    $query = "SELECT * FROM user WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
            foreach ($errors as $error){
                echo $error .'<br>';
            }
        echo '</div>';
    }
}   

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

if (isset($_POST['change_btn'])) { // first time user change password
    change();
}

if (isset($_POST['changePass'])) { //admin change password
    oldPass();
}


if (isset($_POST['inactive'])) {
    active();
}

if (isset($_POST['pro'])) {
    product();
}

function oldPass(){
    global $db, $username, $errors;

    // grap form values
    $id = e($_POST['id']);
    $old = e($_POST['oldpass']);
    $pass1 = e($_POST['pass1']);
    $pass2 = e($_POST['pass2']);
    $mysqli_page = $db->query("select * from login where UserID  ='$id'");
	if ($mysqli_page->num_rows > 0){
        $logged_in_user = $mysqli_page->fetch_array(MYSQLI_ASSOC);
        if ( password_verify($old, $logged_in_user['Pass']) ){
            if($pass2==$pass1){
        
                $word=password_hash($pass2, PASSWORD_DEFAULT );
        
                $get_banner="update login set Pass=? where UserID=?";
                $run_banners = query($get_banner,[$word,$id]);
                if($run_banners){
                    echo '<script>alert ("Successfully Update Password");window.location.href = "profile.php";</script>';
                    
                }else{
                    echo '<script>alert ("FAIL! Please try again.");window.location.href = "profile.php";</script>';
                }
            }else{
                echo '<script>alert ("Password does not match");window.location.href = "change.php";</script>';
            }
        }else{
            echo '<script>alert ("Old Password does not match");window.location.href = "change.php";</script>';
        }
    }

}

function active(){    
    $ID = e($_POST['id']);
    $get_banner="update login set status=? where UserID=?";
    $run_banners = query($get_banner,['active',$ID]);
    if($run_banners){
        if($run_banners){
            echo '<script>alert ("Successfully Activate");window.location.href = "user(A).php";</script>';
            
        }else{
            echo '<script>alert ("FAIL! Please try again.");window.location.href = "user(A).php";</script>';
        }
                               
  }
}
 
function product(){    

    $ID = e($_POST['id']);
    $get_banner="update product set status=? where ProductID=?";
    $run_banners = query($get_banner,['active',$ID]);
    if($run_banners){
        if($run_banners){
            echo '<script>alert ("Successfully Activate");window.location.href = "Inventory.php";</script>';
            
        }else{
            echo '<script>alert ("FAIL! Please try again.");window.location.href = "Inventory.php";</script>';
        }
                               
  }
}




//change password
function change(){
    global $db, $username, $errors;

    // grap form values
    $pass1 = e($_POST['pass1']);
    $pass2 = e($_POST['pass2']);
    $id = e($_POST['id']);

    // make sure form is filled properly


    if($pass2==$pass1){
        
        $word=password_hash($pass2, PASSWORD_DEFAULT );

        $get_banner="update login set Pass=? where UserID=?";
        $run_banners = query($get_banner,[$word,$id]);
        if($run_banners){
            session_destroy();
            unset($_SESSION['user']);
            echo '<script>alert ("Successfully Update Password");window.location.href = "login.php";</script>';
            
        }else{
            session_destroy();
            unset($_SESSION['user']);
            echo '<script>alert ("FAIL! Please try again.");window.location.href = "login.php";</script>';
        }
    }else{
        echo '<script>alert ("Password does not match");window.location.href = "login.php";</script>';
    }
}

// LOGIN USER
function login(){
    global $db, $username, $errors;

    // grap form values
    $id = e($_POST['id']);
    $password = e($_POST['password']);
    
    // attempt login if no errors on form
    $mysqli_page = $db->query("select * from login where UserID  ='$id'");
	if ($mysqli_page->num_rows > 0){
        
		$logged_in_user = $mysqli_page->fetch_array(MYSQLI_ASSOC);
        if ($logged_in_user['status']=='active'){
		    if ( password_verify($password, $logged_in_user['Pass']) ){
                if($logged_in_user['UserPass']== $logged_in_user['Pass']){
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  ;
                    header('location: changePass.php');
                }
                else if ($logged_in_user['TypeName'] == "student") {
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  ;
                    header('location: StudDash.php');         
                }else if ($logged_in_user['TypeName'] == "teacher"){
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  ;
                    header('location: Dash.php');
                }else{
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  ;
                    header('location: Dash.php');
                }
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }else{
            array_push($errors, "Try again");
        }
    }
}

function isAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}

function isTeacAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'admin' ) {
        return true;
    }else if (isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'teacher' ){
        return true;
    }else{
        return false;
    }
}

function isAll()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'admin' ) {
        return true;
    }else if (isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'teacher' ){
        return true;
    }elseif(isset($_SESSION['user']) && $_SESSION['user']['TypeName'] == 'student'){
        return true;
    }else{
        return false;
    }
}

$mysqli = new mysqli('localhost', 'root', '', 'school_inventory');

function query($sql, $data = '') {
    global $db;

    $newdata = array();
    $stmt=mysqli_prepare($db,$sql); 
    if ( !empty($data) ){
        if ( is_array($data) ){
            foreach( $data as $k => $v ){
                $newdata[$k] = &$data[$k];
            }
        }else{
            $newdata = array(&$data);
        }
        $type = str_repeat('s', count($newdata));
        array_unshift($newdata, $stmt, $type);
        call_user_func_array("mysqli_stmt_bind_param",$newdata);
    }


    if(!mysqli_stmt_execute($stmt))
    {
        return false;
    }else{
        return true;
    }
}



