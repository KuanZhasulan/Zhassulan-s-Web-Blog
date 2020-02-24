<?php

require_once('foundation.php');



if(!$enter){ header('Location: login.php'); }

if(isset($_GET['delpost'])){ 

    $stmt = $blog->prepare('DELETE FROM blog_pub WHERE pubID = :pubID') ;
    $stmt->execute(array(':pubID' => $_GET['delpost']));

     
    $stmt = $blog->prepare('DELETE FROM matching WHERE pubID = :pubID');
    $stmt->execute(array(':pubID' => $_GET['delpost']));

    header('Location: admin_index.php?action=deleted');
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
  function delpost(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'admin_index.php?delpost=' + id;
      }
  }
  </script>
</head>
<body>
    <?php include('menu.php');?>

    <div class="container">

    
    <?php 
    
    if(isset($_GET['action'])){ 
        echo '<h3>Post '.$_GET['action'].'.</h3>'; 
    } 
    ?>

     <table class="table table-hover table-bordered">
          <thead>
            <tr class="info">
              <th>Title</th>
              <th>Date</th>
              <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
        
   

   
    <?php
        try {

            $stmt = $blog->query('SELECT pubID, pubTitle, pubDate FROM blog_pub ORDER BY pubID DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['pubTitle'].'</td>';
                echo '<td>'.date('jS M Y', strtotime($row['pubDate'])).'</td>';
                ?>

                <td>
                    <a href="edit-post.php?id=<?php echo $row['pubID'];?>" class="btn btn-info" role="button">Edit</a> | 
                    <a class="btn btn-info" role="button" href="javascript:delpost('<?php echo $row['pubID'];?>','<?php echo $row['pubTitle'];?>')">Delete</a>
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

    <p><a href='add-post.php' class="btn btn-info" role="button">Add Publication</a></p>

</div>

</body>
</html>