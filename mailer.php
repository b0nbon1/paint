<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "nyabuyabonvic@gmail.com";
    // $email_subject = "Your email subject line";
 
    function died($error) {
      header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. \n";
        echo "These errors appear below.\n\n";
        echo $error;
        echo "Please go back and fix these errors.";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['email']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['message'])) {
        die('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $name = $_POST['name']; // required
    $telephone = $_POST['telephone']; // required
    $email_from = $_POST['email']; // required
    $subject = $_POST['subject']; // not required
    $message = $_POST['message']; // required
 
    $error_message = "";
    $email_exp = '/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid. <br>';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The Name you entered does not appear to be valid. <br>';
  }
 
    $number_exp = "/^[+#*\(\)\[\]]*([0-9][ ext+-pw#*\(\)\[\]]*){6,45}$/";

  if(!preg_match($number_exp, $telephone)) {
    $error_message .= 'The Phone Number Name you entered does not appear to be valid. <br>';
  }
 
  if(strlen($message) < 2) {
    $error_message .= 'The message you entered do not appear to be valid. <br>';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "First Name: ".clean_string($name)."\n";
    $email_message .= "Last Name: ".clean_string($telephone)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "subject: ".clean_string($subject)."\n";
    $email_message .= "message: ".clean_string($message)."\n";

    ini_set("SMTP","aspmx.l.google.com");
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    if(mail($email_to, $subject, $email_message, $headers)) {
      echo 'Email sent successfully!';
    } else {
        die('Failure: Email was not sent!');
    }  
    ?>

    Thank you for contacting us. We will be in touch with you very soon.
    
    <?php
 
}
?>
