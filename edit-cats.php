<?php 
require_once('foundation.php');

if(!$enter){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Category</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <?php include('menu.php');?>
    <div class="container">

    <div class="page-header">
                    <h1>Edit Category</h1>
    </div>


    <?php

    
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        
        extract($_POST);

        
        if($catID ==''){
            $error[] = 'This post is missing a valid id!.';
        }

        if($catTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if(!isset($error)){

            try {


                
                $stmt = $blog->prepare('UPDATE blog_categories SET catTitle = :catTitle WHERE catID = :catID') ;
                $stmt->execute(array(
                    ':catTitle' => $catTitle,
                    ':catID' => $catID
                ));

                
                header('Location: categories.php?action=updated');
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

            $stmt = $blog->prepare('SELECT catID, catTitle FROM blog_categories WHERE catID = :catID') ;
            $stmt->execute(array(':catID' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post' class="text-center" style="margin: 0px auto; width: 25%;">
        <input type='hidden' name='catID' value='<?php echo $row['catID'];?>'>

        <div class="form-group">
            <label for="catTitle">Title</label>
            <input type='text' name='catTitle' value='<?php echo $row['catTitle'];?>'>
        </div> 

        <div class="form-group">
            <input type='submit' name='submit' value='Update' class="btn btn-danger">
        </div>

    </form>

</div>

</body>
</html>    