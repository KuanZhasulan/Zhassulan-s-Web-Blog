<?php
require_once('foundation.php');

$stmt2 = $blog->prepare("SELECT catTitle, catID FROM blog_categories WHERE catID = :catID");
$stmt2->execute(array(':catID' => $_GET['id']));
$row = $stmt2->fetch();
if($row['catID'] == ''){
    header('Location: ./');
    exit;
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['catTitle'];?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style type="text/css">
     
 </style>
 <link rel="stylesheet" type="text/css" href="mycss.css">

</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Zhassulan's Web Blog</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li class="active success"><a href="cat.php">Categories</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <div class="well">
     Posts in <?php echo $row['catTitle'];?>   
    </div>
    <div class="row"> 
      <div class="col-md-8">
        <div class="panel-group">
       
        <?php
try{
       $stmt3 = $blog->prepare('
       	SELECT blog_pub.pubID, blog_pub.pubTitle, blog_pub.pubDesc, blog_pub.pubDate 
       	FROM blog_pub,
       	matching
       	WHERE matching.pubID =
       	blog_pub.pubID AND matching.catID = :catid ORDER BY pubID DESC');
       $stmt3->execute(array(':catid' => $row['catID']));
            while($row = $stmt3->fetch()){
                
            echo "<div class='panel panel-primary mypanels'>";
            echo '<div class="panel-heading">'.$row['pubTitle']."</div>";
            echo "<div class='panel-body cate'>";
            echo '<p> <span class="badge">'.date("jS M Y H:i:s", strtotime($row['pubDate'])).'</span> </p>';
             $stmt2 = $blog->prepare("SELECT catTitle, blog_categories.catID FROM blog_categories INNER JOIN matching ON blog_categories.catID = matching.catID WHERE matching.pubID = :pubid ");
             $stmt2->execute(array("pubid" => $row['pubID']));
             $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
             $links = array();
             foreach ($catRow as $cat) {
                 $links[] = "<a  class='btn btn-info capitall' role='button' href='cat.php?id=".$cat['catID']."'>".$cat['catTitle']."</a>";
         }
             echo implode(", ", $links);
             echo "</div>";
             echo '<div class="panel-body">'.$row['pubDesc'].'</div>';
             echo '<div class="panel-footer myleftee">
             <a  class="btn btn-info" role="button" href = "viewpost.php?id='.$row['pubID'].'">Read more</a></div>';
            echo "</div>";
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        ?>
</div>
      
      </div>

<div class="col-md-4">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Latest Posts</div>
                <div class="panel-body">
                    <ul class="list-group">
                     <li class="list-group-item">Homo Sapiens<span class="badge">06.11.2017</span></li>
                     <li class="list-group-item">Why am I so clever?<span class="badge">05.11.2017</span></li> 
                     <li class="list-group-item">The Art of Acquiscence<span class="badge">05.11.2017</span></li> 
                     <li class="list-group-item">Python for idiots. A short guide<span class="badge">05.11.2017</span></li> 
                     <li class="list-group-item">How to lie effectively<span class="badge">04.11.2017</span></li> 
                    </ul>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">Categories</div>
                <div class="panel-body">
                <?php
        try {

            $stmt = $blog->query('SELECT catID, catTitle FROM blog_categories ORDER BY catTitle DESC');
            while($row = $stmt->fetch()){
                
               
                echo '<a href = "cat.php?id='.$row['catID'].'" class="btn btn-danger btn-block" role ="button">'.$row['catTitle'].'</a>';
             

                   }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
        
                </div>
            </div>
        </div>
        
      
      </div>
        
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mypags">
             <a href="#">&laquo;</a>
             <a href="#">1</a>
             <a href="#" class="primary">2</a>
             <a href="#">3</a>
             <a href="#">4</a>
             <a href="#">5</a>
             <a href="#">6</a>
             <a href="#">&raquo;</a>
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


