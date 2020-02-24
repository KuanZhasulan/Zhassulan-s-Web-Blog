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
    <style type="text/css">
      #success_message {  
        display: none;
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
      <li class=""><a href="index.php">Home</a></li>
      <li class=""><a href="#">Categories</a></li>
      <li class="active success"><a href="contact.php">Contact</a></li>
    </ul>
  </div>
</nav>


<div class="container">

  <?php 
    
    if(isset($_GET['action'])){ 
        echo '<h3>Message '.$_GET['action'].'.</h3>'; 
    } 
    ?>

  <?php
$checked = '';

    if(isset($_POST['Send'])){

       

        
        extract($_POST);

        
        if($messFirstName ==''){
            $error[] = 'Please enter the title.';
        }

        if($messLastName ==''){
            $error[] = 'Please enter the description.';
        }

        if($messEmail ==''){
            $error[] = 'Please enter the content.';
        }

        if($messPhone ==''){
            $error[] = 'Please enter the content.';
        }

        if($messComment ==''){
            $error[] = 'Please enter the content.';
        }

        if(!isset($error)){

         try {


    
    $stmt = $blog->prepare('INSERT INTO blog_messages (messFirstName, messLastName, messEmail, messPhone, messComment) VALUES (:messFirstName, :messLastName, :messEmail, :messPhone, :messComment)') ;
    $stmt->execute(array(
        ':messFirstName' => $messFirstName,
        ':messLastName' => $messLastName,
        ':messEmail' => $messEmail,
        ':messPhone' => $messPhone,
        ':messComment' => $messComment
    ));
   
    header('Location: contact.php?action=added');
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

    <form class="well form-horizontal" action="" method="post"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend>Contact Us Today!</legend>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="messFirstName" placeholder="First Name" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="messLastName" placeholder="Last Name" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->
       <div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="messEmail" placeholder="E-Mail Address" class="form-control"  type="text">
    </div>
  </div>
</div>


<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Phone #</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="messPhone" placeholder="(845)555-1212" class="form-control" type="text">
    </div>
  </div>
</div>


   


  
<div class="form-group">
  <label class="col-md-4 control-label">Message</label>
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
          <textarea class="form-control" name="messComment" placeholder="Message"></textarea>
  </div>
  </div>
</div>

<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <input name="Send" type="submit" class="btn btn-warning" >
  </div>
</div>

</fieldset>
</form>
</div>
    </div><!-- /.container -->




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
<script type="text/javascript">
  $(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            first_name: {
                validators: {
                        stringLength: {
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your first name'
                    }
                }
            },
             last_name: {
                validators: {
                     stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please supply your last name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your phone number'
                    },
                    phone: {
                        country: 'US',
                        message: 'Please supply a vaild phone number with area code'
                    }
                }
            },
            address: {
                validators: {
                     stringLength: {
                        min: 8,
                    },
                    notEmpty: {
                        message: 'Please supply your street address'
                    }
                }
            },
            city: {
                validators: {
                     stringLength: {
                        min: 4,
                    },
                    notEmpty: {
                        message: 'Please supply your city'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'Please select your state'
                    }
                }
            },
            zip: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your zip code'
                    },
                    zipCode: {
                        country: 'US',
                        message: 'Please supply a vaild zip code'
                    }
                }
            },
            comment: {
                validators: {
                      stringLength: {
                        min: 10,
                        max: 200,
                        message:'Please enter at least 10 characters and no more than 200'
                    },
                    notEmpty: {
                        message: 'Please supply a description of your project'
                    }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
});


</script>
</body>
</html>




