<?php
require_once('foundation.php');
$stmt = $blog->prepare("SELECT pubID, pubTitle, pubDesc, pubCont, pubDate FROM blog_pub WHERE pubID = :pubId");
$stmt->execute(array('pubId' => $_GET['id']));
$row = $stmt->fetch();

if($row['pubID'] == "")
{
	header("Location: ./");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $row['pubTitle']; ?></title>
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
      <li class=" success"><a href="index.php">Home</a></li>
      <li><a href="#">Categories</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </div>
</nav>
<div class="container">
	<div class="row ">
	  <div class="col-md-12">


<?php
echo  '<div class="panel panel-default">';
echo  '<div class="panel-heading">';
echo  '<h1>'.$row['pubTitle'].'</h1>';
echo  '</div>';
echo  '<div  class="panel-body">';
echo  '<button class="btn btn-success btn-xs" data-target = "#cla" data-toggle = "collapse">Categories</button>';
echo  '  <span class = "badge">'.date('jS M Y', strtotime($row['pubDate'])).'</span><hr>';
echo  '<div class="collapse" id="cla" >';

$stmt2 = $blog->prepare("SELECT catTitle, blog_categories.catID FROM blog_categories INNER JOIN matching ON blog_categories.catID = matching.catID WHERE matching.pubID = :pubid ");
		 $stmt2->execute(array("pubid" => $row['pubID']));
		 $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		 $links = array();
		 foreach ($catRow as $cat) {
		 $links[] = "<a class='btn btn-success btn-xs' role='button' href='cat.php?id=".$cat['catID']."'>".$cat['catTitle']."</a>";
		 }
		 echo implode(", ", $links);
echo '</div></div>';
echo '<div class="panel-body">';
echo '<p>'.$row['pubCont'].'</p>';
echo '<div>';
echo '</div>';





?>
</div>
</div>
    </div>

<div class="container-fluid">
 <div class="row">
  <div class="col-md-12">
	<div id="disqus_thread"></div>
	<script>

	/**
	*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
	*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
	/*
	var disqus_config = function () {
	this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
	this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
	};
	*/
	(function() { // DON'T EDIT BELOW THIS LINE
	var d = document, s = d.createElement('script');
	s.src = 'https://parzifal.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
	})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
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
