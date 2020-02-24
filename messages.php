<?php
require_once('foundation.php');

if(!$enter) {
   header("Location: login.php");
}
if(isset($_GET['delete']))
{
  echo "BOOOO";
	$stmt = $blog->prepare("DELETE FROM blog_messages WHERE messID = :messid");
	$stmt->execute(array('messid' => $_GET['delete']));
	header('Location: messages.php?action=deleted');
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
  function delmess(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'messages.php?delete=' + id;
      }
  }
  </script>
</head>
<body>
    <?php include('menu.php');?>
    <div class="container">

    

    <?php 
    
    if(isset($_GET['action'])){ 
        echo '<h3>Message '.$_GET['action'].'.</h3>'; 
    } 
    ?>

     <table class="table table-hover table-bordered">
          <thead>
            <tr class="danger">
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Comment</th>
              <th>Action</th>
          </tr>
        </thead>
        <tbody>
    <?php
        try {

            $stmt = $blog->query('SELECT messID, messFirstName, messLastName, messEmail, messPhone, messComment FROM blog_messages ORDER BY messID DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['messFirstName'].'</td>';
                echo '<td>'.$row['messLastName'].'</td>';
                echo '<td>'.$row['messEmail'].'</td>';
                echo '<td>'.$row['messPhone'].'</td>';
                echo '<td>'.$row['messComment'].'</td>';
                ?>

                <td> 
                    <a class="btn btn-danger" role="button" href="javascript:delmess('<?php echo $row['messID'];?>','<?php echo $row['messFirstName'];?>')">Delete</a>
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


</div>

</body>
</html>