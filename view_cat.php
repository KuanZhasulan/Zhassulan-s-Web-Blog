<?php require_once('foundation.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Zhassulan's Web Blog</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <meta charset="utf-8"> 
    <link rel="stylesheet" type="text/css" href="mycss.css"> 
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Zhassulan's Web Blog</a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="index.php">Home</a></li>
      <li class="active success"><a href="view_cat.php">Categories</a></li>
      <li><a href="contact.php">Contact</a></li>
     
    </ul>
  </div>
</nav>
<div class="container-fluid">
	<div class="row"> 
	  <div class="col-md-12">
	  	
	  	<div class="panel-group">
       <div class='panel panel-danger mypanels'>
        <div class="panel-heading">Categories</div>
        <div class='panel-body cate'>  
       <?php
        $stmt = $blog->query("SELECT catTitle, catID FROM blog_categories ORDER BY catTitle");

          while($row = $stmt->fetch())
          {
            echo "<a  class='btn btn-danger capitall btn-block' role='button' href='cat.php?id=".$row['catID']."'>".$row['catTitle']."</a>";
          }

       ?>


       </div>
       </div>
      </div>

      </div>

<div class="container-fluid">
  <div class="row">
     <div class="col-md-12">
      <div class="jumbotron">
         <h1>Zhassulan's Web Blog</h1> 
         <p>Do you like this blog? If you want one like this for yourself you can contact me at: XXX-XXX-XXX</p> 
        </div>
     </div>
  </div>
</div>

</body>
</html>