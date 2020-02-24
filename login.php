<?php
require_once('foundation.php');

if($enter){ header('Location: admin_index.php'); } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="logstyle.css">
  <style type="text/css">
    .you {
      position: absolute;
      right: 40px;
      top: 140px;
    }
  </style>
  </head>
<body>
<div class="zag">
  <span>DUNGEON MASTER</span>
</div>



    <?php


    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $username = sanitize($username);
        $password = sanitize($password);
        
       if ($username == "" || $password == ""){
        $message = "Not all fields were entered<br>";
      }
    elseif(strlen($username) < 5)
    {
      $message = "The username can not be shorter than 5 characters";
    }
    else
    {
        try
      {
        $roar = $blog->prepare("SELECT * FROM blog_moderators WHERE moderatorname = :user AND password = :pass");
        $roar->execute(array(
        ':user' => $username,
        ':pass' => $password
    ));
        $row = $roar->fetch();
        if(isset($row['moderatorID']))
      {
        $_SESSION['admin'] = $username;
        $_SESSION['pass'] = $password;
        header("Location: admin_index.php");
      } 
      else 
      {
            $message = '<p class="error">Wrong username or password</p>';
        }

    }
    catch(PDOException $e)
    {
         $e->getMessage();
    }
   
   }
 }
    if(isset($message)){ echo $message; }
    ?>

    <form id="log" action="" method="post">
 <ul>
  <a href="#" id = "login"><li class="active table two">YOU SHALL NOT PASS</li></a>
 </ul>
 <div id="sign">
 
  <div class="field">
   <input type="text" name="username">
   <label>Username<span>*</span></label>
  </div> 
  <div class="field">
   <input type="text" name="password">
   <label>Password<span>*</span></label>
  </div>
  <input type="submit" name="submit" value="Login" id="sub">

 </div>

 

   </form>
   <img src="shallnotpass.png" class="you" width="25%" height="75%">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
$('#log').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.next('label');

    if (e.type === 'keyup') {
      if ($this.val() === '') {
          label.removeClass('pick highlight');
        } else {
          label.addClass('pick highlight');
        }
    } else if (e.type === 'blur') {
      if( $this.val() === '' ) {
        label.removeClass('pick highlight'); 
      } else {
        label.removeClass('highlight');   
      }   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
        label.removeClass('highlight'); 
      } 
      else if( $this.val() !== '' ) {
        label.addClass('highlight');
      }
    }

});


</script>


</div>
</body>
</html>