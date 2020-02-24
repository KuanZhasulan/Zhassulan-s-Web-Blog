<?php 
require_once('foundation.php');


if(!$enter){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Category</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>



    <?php include('menu.php');?>
    <div class = "container">

        <div class="page-header">
                    <h1>Add Category</h1>
        </div>

    <?php

    
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        
        extract($_POST);

        
        if($catTitle ==''){
            $error[] = 'Please enter the Category.';
        }

        if(!isset($error)){

            try {


                
                $stmt = $blog->prepare('INSERT INTO blog_categories (catTitle) VALUES (:catTitle)') ;
                $stmt->execute(array(
                    ':catTitle' => $catTitle,
                    
                ));

            
                header('Location: categories.php?action=added');
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

    <form action='' method='post' class="text-center" style="margin: 0px auto; width: 25%;">

        <div class="form-group">
            <label for = "catTitle">Title</label>
            <input type='text' name='catTitle' value='<?php if(isset($error)){ echo $_POST['catTitle'];}?>'>
        </div>

        <div class="form-group">
            <input type='submit' name='submit' value='Submit' class="btn btn-danger">
        </div>
    </form>

</div>