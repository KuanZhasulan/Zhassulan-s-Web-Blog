<?php 
require_once('foundation.php');


if(!$enter){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
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
                <h1>Edit Post</h1>
    </div>


    <?php

    
    if(isset($_POST['submit'])){



        
        extract($_POST);

        
        if($pubID ==''){
            $error[] = 'This post is missing a valid id!.';
        }

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

    

    
    $stmt = $blog->prepare('UPDATE blog_pub SET pubTitle = :pubTitle, pubDesc = :pubDesc, pubCont = :pubCont WHERE pubID = :pubID') ;
    $stmt->execute(array(
        ':pubTitle' => $pubTitle,
        ':pubDesc' => $pubDesc,
        ':pubCont' => $pubCont,
        ':pubID' => $pubID
    ));

    $stmt = $blog->prepare('DELETE FROM matching WHERE pubID = :pubID');
$stmt->execute(array(':pubID' => $pubID));

if(is_array($catID)){
    foreach($_POST['catID'] as $catID){
        $stmt = $blog->prepare('INSERT INTO matching (pubID,catID) VALUES(:pubID,:catID)');
        $stmt->execute(array(
            ':pubID' => $pubID,
            ':catID' => $catID
        ));
    }
}

    
    header('Location: admin_index.php?action=updated');
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

            $stmt = $blog->prepare('SELECT pubID, pubTitle, pubDesc, pubCont FROM blog_pub WHERE pubID = :pubID') ;
            $stmt->execute(array(':pubID' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='pubID' value='<?php echo $row['pubID'];?>'>

        <div class="form-group">
            <label for="pubTitle">Title</label>
            <input class="form-control" type='text' name='pubTitle' value='<?php echo $row['pubTitle'];?>'>
        </div> 
        <p><label>Description</label><br />
        <textarea name='pubDesc' cols='60' rows='10'><?php echo $row['pubDesc'];?></textarea></p>

        <p><label>Content</label><br />
        <textarea name='pubCont' cols='60' rows='10'><?php echo $row['pubCont'];?></textarea></p>

<div class="form-group">
    <label for = "categories" class="control-label col-md-2">Categories</label>
    <div class="col-md-10">
    <?php

    $stmt2 = $blog->query('SELECT catID, catTitle FROM blog_categories ORDER BY catTitle');
    while($row2 = $stmt2->fetch()){

        $stmt3 = $blog->prepare('SELECT catID FROM matching WHERE catID = :catID AND pubID = :pubID') ;
        $stmt3->execute(array(':catID' => $row2['catID'], ':pubID' => $row['pubID']));
        $row3 = $stmt3->fetch(); 

        if($row3['catID'] == $row2['catID']){
            $checked = 'checked=checked';
        } else {
            $checked = null;
        }

        echo "<div class = 'checkbox'><label class='control-label'><input id='categories' type='checkbox' name='catID[]' value='".$row2['catID']."' $checked>".$row2['catTitle']."<label></div>";
    }

    ?>

   </div>  
</div>

        <p><input type='submit' name='submit' value='Update' class="btn btn-warning"></p>

    </form>

</div>

</body>
</html> 