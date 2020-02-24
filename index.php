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
    <style>
    .nounderline {
    	text-decoration: none;
    }
     a:link {
     	text-decoration: none;
     	color: black;
     }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Zhassulan's Web Blog</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active success"><a href="#">Home</a></li>
      <li><a href="view_cat.php">Categories</a></li>
      <li><a href="contact.php">Contact</a></li>
     
    </ul>
  </div>
</nav>
<div class="container">
	<div class="row"> 
	  <div class="col-md-8">
	  	
	  	<div class="panel-group">
      
       
	  

<?php
$perPage = 5;

if(isset($_GET['page']))
{
	$page = ($_GET['page'] - 1);
}
else
{
	$page = 0;
}

$start = abs($perPage*$page);

try{
	$rowMan = $blog->query("SELECT count(*) FROM blog_pub");
	$rowNum = $rowMan->fetch();
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

$pageNumber = ceil($rowNum[0]/$perPage);



try {
	$stmt = $blog->query("SELECT pubID, pubTitle, pubDesc, pubDate FROM blog_pub ORDER BY pubID DESC LIMIT $start, $perPage");
	while($row = $stmt->fetch())
	{
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
}
catch(PDOException $e)
{
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
	    			<?php
	    			try {
	                 $stmt = $blog->query("SELECT pubID, pubTitle, pubDesc, pubDate FROM blog_pub ORDER BY pubID DESC LIMIT 5");
	                 while($row = $stmt->fetch())
	                 {
						
						echo '<a class="nounderline" href="viewpost.php?id='.$row['pubID'].'"><li class="list-group-item">'.$row['pubTitle'].'<span class="badge">'.date("jS M Y H:i:s", strtotime($row['pubDate'])).'</span></li></a>';
                   
                     }
                    }
                    catch(PDOException $e){
                    	echo $e->getMessage();
                    }

                    ?>
                    </ul>
	    		</div>
	    	</div>

	    	<br>
	    	<div class="panel panel-primary">
	    		<div class="panel-heading">
	    			Categories
	    		</div>
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
			<?php
            echo '<a href="#">&laquo;</a>';
             

			for($i = 1; $i <= $pageNumber; $i++)
			{
				if($i - 1 == $page){
					echo '<a href="#" class="primary">'.$i.'</a>';
				}
				else
				{
					echo '<a href = "index.php?page='.$i.'">'.$i.'</a>';
				}
			}
             
            echo  '<a href="#">&raquo;</a>'; 

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




