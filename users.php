<?php

require_once('foundation.php');


if(!$enter){ header('Location: login.php'); }

if(isset($_GET['deluser'])){ 

    
    if($_GET['deluser'] !='1'){

        $stmt = $blog->prepare('DELETE FROM blog_moderators WHERE moderatorID = :moderatorID') ;
        $stmt->execute(array(':moderatorID' => $_GET['deluser']));

        header('Location: users.php?action=deleted');
        exit;

    }
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Users</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'users.php?deluser=' + id;
      }
  }
  </script>
</head>
<body>
    <?php include('menu.php');?>

    <div class="container">

   
    <?php 
    
    if(isset($_GET['action'])){ 
        echo '<h3>User '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table class="table table-hover table-bordered">
          <thead>
            <tr class="success">
              <th>Username</th>
              <th>Email</th>
              <th>Action</th>
          </tr>
        </thead>
        <tbody>
    <?php
        try {

            $stmt = $blog->query('SELECT moderatorID, moderatorname, email FROM blog_moderators ORDER BY moderatorname');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['moderatorname'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                ?>

                <td>
                    <a class="btn btn-success" role="button" href="edit-user.php?id=<?php echo $row['moderatorID'];?>">Edit</a> 
                    <?php if($row['moderatorID'] != 1){?>
                        | <a class="btn btn-success btn" role="button" href="javascript:deluser('<?php echo $row['moderatorID'];?>','<?php echo $row['moderatorname'];?>')">Delete</a>
                    <?php } ?>
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

    <p><a href='add-user.php' class="btn btn-success" role="button">Add User</a></p>

</div>

</body>
</html>