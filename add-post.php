<?php 
require_once('foundation.php');


if(!$enter){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add Post</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style type="text/css">
     
 </style>
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

 <?php include('menu.php');?>
<div class="container">

   
    <div class="page-header">
                <h1>Add Post</h1>
    </div>
    <?php
$checked = '';

    if(isset($_POST['submit'])){

       

        
        extract($_POST);

        
        if($pubTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if($pubDesc ==''){
            $error[] = 'Please enter the description.';
        }

        if($pubCont ==''){
            $error[] = 'Please enter the content.';
        }

        if(!isset($error)){

         try {


    
    $stmt = $blog->prepare('INSERT INTO blog_pub (pubTitle, pubDesc, pubCont, pubDate) VALUES (:pubTitle, :pubDesc, :pubCont, :pubDate)') ;
    $stmt->execute(array(
        ':pubTitle' => $pubTitle,
        ':pubDesc' => $pubDesc,
        ':pubCont' => $pubCont,
        ':pubDate' => date('Y-m-d H:i:s')
    ));
   $pubID = $blog->lastInsertId();


if(isset($catsID)){
    foreach($catsID as $item){
        $stmt3 = $blog->prepare('INSERT INTO matching(pubID, catID) VALUES(:pubID, :catID)');
        $stmt3->execute(array(
            ':pubID' => $pubID,
            ':catID' => $item
        ));
    }
}
    
    header('Location: admin_index.php?action=added');
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


     <form action='' method='post'>
        <input type='hidden' name='pubID' value='<?php echo $row['pubID'];?>'>

        <div class="form-group">
            <label for="pubTitle">Title</label>
            <input class="form-control" type='text' name='pubTitle' value='<?php if(isset($error)){ echo $_POST['pubTitle'];}?>'>
        </div> 
        <p><label>Description</label><br />
        <textarea name='pubDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['pubDesc'];}?></textarea></p>

        <p><label>Content</label><br />
        <textarea name='pubCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['pubCont'];}?></textarea></p>

<div class="form-group">
    <label for = "categories" class="control-label col-md-2">Categories</label>
    <div class="col-md-10">
    <?php

   $stmt2 = $blog->query('SELECT catID, catTitle FROM blog_categories ORDER BY catTitle');
    while($row2 = $stmt2->fetch()){

        if(isset($_POST['catsID'])){

            if(in_array($row2['catID'], $_POST['catsID'])){
               $checked = "checked ='checked'";
            }else{
               $checked = '';
            }
        }

        echo "<div class = 'checkbox'><label class='control-label'><input id='categories' type='checkbox' name='catID[]' value='".$row2['catID']."' $checked>".$row2['catTitle']."<label></div>";
    }

    ?>

   </div>  
</div>

        <p><input type='submit' name='submit' value='Add' class="btn btn-warning"></p>

    </form>
</div>

</body>
</html> 