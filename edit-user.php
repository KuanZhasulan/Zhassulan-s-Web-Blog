<?php 
require_once('foundation.php');


if(!$enter){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit User</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style type="text/css">
     
 </style>
</head>
<body>
<?php include('menu.php');?>
<div class="container">

    

    <div class="page-header">
                <h1>Edit User</h1>
    </div>


    <?php

    
    if(isset($_POST['submit'])){

    
        extract($_POST);

        
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if( strlen($password) > 0){

            if($password ==''){
                $error[] = 'Please enter the password.';
            }

            if($passwordConfirm ==''){
                $error[] = 'Please confirm the password.';
            }

            if($password != $passwordConfirm){
                $error[] = 'Passwords do not match.';
            }

        }
        

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            try {

                if(isset($password)){

                

                    
                    $stmt = $blog->prepare('UPDATE blog_moderators SET moderatorname = :username, password = :password, email = :email WHERE moderatorID = :moderatorID') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':password' => $password,
                        ':email' => $email,
                        ':moderatorID' => $moderatorID
                    ));


                } else {

                    
                    $stmt = $blog->prepare('UPDATE blog_moderators SET moderatorname = :username, email = :email WHERE moderatorID = :moderatorID') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':email' => $email,
                        ':moderatorID' => $moderatorID
                    ));

                }
                

                
                header('Location: users.php?action=updated');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    ?>


    <?php

    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br />';
        }
    }

        try {

            $stmt = $blog->prepare('SELECT moderatorID, moderatorname, email FROM blog_moderators WHERE moderatorID = :moderatorID') ;
            $stmt->execute(array(':moderatorID' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form class="form-horizontal" action="" method="post">
        <input type='hidden' name='moderatorID' value='<?php echo $row['moderatorID'];?>'>

        <div class="form-group">
            <label for = "username" class="control-label col-md-2">Username</label>
            <div class="col-md-10">
                <input class="form-control" type='text' name='username' value='<?php echo $row['moderatorname'];?>'>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="password">Password (only to change)</label>
            <div class="col-md-10">
                <input type='password' name='password' value='' class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="passwordConfirm">Confirm Password</label>
            <div class="col-md-10">
                <input class="form-control" type='password' name='passwordConfirm' value=''>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="email">Email</label>
            <div class="col-md-10">
                <input class="form-control" type='text' name='email' value='<?php echo $row['email'];?>'>
            </div>    
        </div>

        <p><input type='submit' name='submit' value='Update User' class="btn btn-warning"></p>

    </form>

</div>

</body>
</html>   