<?php 

require_once '_config.php';
if(isset($_SESSION['admin_user_login']) == true ){ header("Location: dashboard.php"); exit; }

// LOGIN POST REQUEST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // RESET PASSWORD EMAIL
    $email = str_replace(' ', '', $_POST['email']);
    $new_password = rand(100000, 999999);
    $user = $db->query("SELECT * FROM `users` WHERE `email` LIKE '".$email."'")->fetchAll();
    if (isset($user[0]['email'])) {} else { 

    ALERT_MSG('wrong_email');
    REDIRECT("login-forget-password.php");

    die; }
    $params = array( "password" => md5($new_password) );
    $id = $user[0]['id'];
    $data = UPDATE('users',$params,$id);

    // SEND EMAIL
    $title = "Forget Password";
    $template = "forget_password";
    $content = $new_password;
    $receiver_email = $user[0]['email'];
    $receiver_name = $user[0]['first_name'];
    MAILER($template,$title,$content,$receiver_email,$receiver_name);

    // INSERT TO LOGS
    $user_id = $user[0]['user_id'];    
    $log_type = "forget_password";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "Generated new password from forget password page and sent to email";
    logs($user_id,$log_type,$datetime,$desc);

    // REDIRECT PAGE
    ALERT_MSG('reset_password');
    REDIRECT("login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Forget Password</title>
      <link rel="shortcut icon" href="../uploads/global/favicon.png">
      <link rel="stylesheet" href="./assets/css/style.css" />
      <script src="./assets/js/jquery-3.6.0.min.js"></script>
   </head>
   <body class="bg-dark">
      <!-- Main content container-->
      <div class="container">
         <div class="row justify-content-center">
         <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8" style="display: flex; align-items: center; height: 100vh;justify-content: center;">
            
                  <div class="card mt-3 mb-4 w-100">
                  <div class="card-body p-3">
                     <div class="text-center">
                        <img class="mb-3" src="../uploads/global/favicon.png" alt="favicon" style="height: 48px">
                     </div>

                     <p class="mb-0 text-center"><strong>Reset Password</strong></p>
                     <p class="mb-0 text-center">Please enter your email below</p>

                     <!-- Login submission form-->
                     <form name="form" action="./login-forget-password.php" method="post" onsubmit="submission()">
                        
                        <div class="mb-2 mt-3">
                           <div class="form-floating">
                           <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                           <label for="">Email</label>
                           </div>
                        </div>
                        
                        <button id="submit" class="login_button mt-1 mb-2 btn btn-primary w-100" type="submit">Reset Password</button>
                        <hr>
                        <a href="./login.php" class="mt-2 btn btn-outline-dark w-100">Back to Login</a>
                        <div class="d-none">
                           <button  class="btn btn-primary w-100 mt-3" type="button" disabled>
                           <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                           Loading...
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

   <script src="./assets/js/toast.js"></script>
   <script src="./assets/js/toast-alerts.js"></script>
   <script src="./assets/js/bootstrap.bundle.min.js"></script>
   <script>
      function submission() {
         document.querySelector('.d-none').classList.remove('d-none');
         document.querySelector('.login_button').classList.add('d-none');
      
         let email = $("#email").val();
         if (email == "") { 
               event.preventDefault(); 
               alert("Email is required to reset password"); 
               window.location.href = "<?=root?>login-forget-password.php";
         }
      }

      var hash = window.location.hash.substr(1);
      if (hash == "invalid") {
      vt.error("Email incorrect please check again",{
      title:"Invalid Email",
      position: "bottom-center",
      callback: function (){
      } })
      }

   </script>

</body>
</html>