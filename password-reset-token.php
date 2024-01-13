<?php
include('functions.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendMail($email, $reset_token, $user){

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 4; 
    try {
        $mail->SMTPDebug = 0; 
        $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
          )
       );
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'waniuse01@gmail.com';                     //SMTP username
        $mail->Password   = 'tngdescnbmxfkvfc';                               //SMTP password
        $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('waniuse01@gmail.com', 'KoopVentory');
        $mail->addAddress($email);     //Add a recipient
        
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password Link from KoopVentory';
        $mail->Body    = 'Link: <a href="http://localhost/FypV2/reset-password.php?UserID='.$user.'&reset_token='.$reset_token.'">
            Reset Password
            </a>';

    
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo 'Email could not be sent.';
    }
    
}

//THE KEY FOR ENCRYPTION AND DECRYPTION
$encryptionKey = base64_encode(32);

function encryptthis($data, $key) {
    // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
    // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
}

function decryptthis($data, $key) {
    // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
    

if(isset($_POST['forgot_btn']))
{
    $user = $_POST['id'];
    $result = mysqli_query($db,"SELECT * FROM admininfo join login WHERE admininfo.UserID='" . $user. "' AND login.status= 'active' AND login.UserID=admininfo.UserID");
    $row= mysqli_fetch_array($result);
    if($row){
        $emailNow = $row['email'];
        $email=decryptthis($emailNow, $encryptionKey); 
        $reset_token=bin2hex(random_bytes(16));
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $date=date("Y-m-d H:i:s ");
        $query="UPDATE token SET reset_link_token= '$reset_token', exp_date= '$date' WHERE UserID= '$user' ";
        if(mysqli_query($db, $query)){
            if(sendMail($email, $reset_token, $user)){
                echo '<script>alert ("Reset password link has been sent to your email ('.$email.')");window.location.href = "login.php";</script>';
            }
            else{
                echo '<script>alert ("Cannot send email");window.location.href = "login.php";</script>';
            }
        }
    }else{
        $result = mysqli_query($db,"SELECT * FROM teacherinfo join login WHERE teacherinfo.UserID='" . $user. "' AND login.status= 'active' AND login.UserID=teacherinfo.UserID");
        $row= mysqli_fetch_array($result);
        if($row){
            $emailNow = $row['email'];
            $email=decryptthis($emailNow, $encryptionKey); 
            $reset_token=bin2hex(random_bytes(16));
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $date=date("Y-m-d H:i:s ");
            $query="UPDATE token SET reset_link_token= '$reset_token', exp_date= '$date' WHERE UserID= '$user' ";
            if(mysqli_query($db, $query)){
                if(sendMail($email, $reset_token, $user)){
                    echo '<script>alert ("Reset password link has been sent to your email ('.$email.')");window.location.href = "login.php";</script>';
                }
                else{
                    echo '<script>alert ("Cannot send email");window.location.href = "login.php";</script>';
                }
            }
        }else{
            $result = mysqli_query($db,"SELECT * FROM studentinfo join login WHERE studentinfo.UserID='" . $user. "' AND login.status= 'active' AND login.UserID=studentinfo.UserID");
            $row= mysqli_fetch_array($result);
            if($row){
                $emailNow = $row['email'];
                $email=decryptthis($emailNow, $encryptionKey); 
                $reset_token=bin2hex(random_bytes(16));
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $date=date("Y-m-d H:i:s ");
                $query="UPDATE token SET reset_link_token= '$reset_token', exp_date= '$date' WHERE UserID= '$user' ";
                if(mysqli_query($db, $query)){
                    if(sendMail($email, $reset_token, $user)){
                        echo '<script>alert ("Reset password link has been sent to your email ('.$email.')");window.location.href = "login.php";</script>';
                    }
                    else{
                        echo '<script>alert ("Cannot send email");window.location.href = "login.php";</script>';
                    }
                }
            }else{
                echo"
                    <script>
                        alert('Invalide User ID Entered');
                        windows.location.href = 'login.php';
                    </script>
                ";
            }
        }
    }
     
}
?>