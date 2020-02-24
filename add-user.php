<?php 
require_once('foundation.php');
if(!$enter){ header('Location: login.php'); }

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add User</title>
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
                <h1>Add User</h1>
    </div>

    <?php


    if(isset($_POST['submit'])){

        
        extract($_POST);
        
        
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

        

            try {

                
                $stmt = $blog->prepare('INSERT INTO blog_moderators (moderatorname,password,email) VALUES (:username, :password, :email)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $password,
                    ':email' => $email
                ));

                
                header('Location: users.php?action=added');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="error">'.$error.'</p>';
        }
    }
    ?>


    <form class="form-horizontal" action="" method="post">

        <div class="form-group">
            <label for = "username" class="control-label col-md-2">Username</label>
            <div class="col-md-10">
                <input class="form-control" type='text' name='username' value="<?php if(isset($error)){ echo $_POST['username'];}?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="password">Password (only to change)</label>
            <div class="col-md-10">
                <input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>' class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="passwordConfirm">Confirm Password</label>
            <div class="col-md-10">
                <input class="form-control" type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="email">Email</label>
            <div class="col-md-10">
                <input class="form-control" type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'>
            </div>    
        </div>

        <p><input type='submit' name='submit' value='Add User' class="btn btn-warning"></p>

    </form>

</div>

</body>
</html> 