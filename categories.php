<?php
require_once('foundation.php');

if(!$enter) {
   header("Location: login.php");
}
if(isset($GET['deluser']))
{
	$stmt->$blog->prepare("DELETE FROM blog_categories WHERE catID = :catid");
	$stmt->execute(array('catid'=> $GET['deluser']));
	header('Location: categories.php?action=deleted');
    exit;
} 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style type="text/css">
     
 </style>
  <script language="JavaScript" type="text/javascript">
  function delcat(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'categories.php?deluser=' + id;
      }
  }
  </script>
</head>
<body>
    <?php include('menu.php');?>
    <div class="container">

    

    <?php 
    
    if(isset($_GET['action'])){ 
        echo '<h3>Category '.$_GET['action'].'.</h3>'; 
    } 
    ?>

     <table class="table table-hover table-bordered">
          <thead>
            <tr class="danger">
              <th>Title</th>
              <th>Action</th>
          </tr>
        </thead>
        <tbody>
    <?php
        try {

            $stmt = $blog->query('SELECT catID, catTitle FROM blog_categories ORDER BY catTitle DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['catTitle'].'</td>';
                ?>

                <td>
                    <a class="btn btn-danger" role="button" href="edit-cats.php?id=<?php echo $row['catID'];?>">Edit</a> | 
                    <a class="btn btn-danger" role="button" href="javascript:delcat('<?php echo $row['catID'];?>','<?php echo $row['catTitle'];?>')">Delete</a>
                </td>
                
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
   </tbody>
    </table>

    <p><a href='add-cats.php' class="btn btn-danger" role="button">Add Category</a></p>

</div>

</body>
</html>