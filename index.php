<?php
session_start();
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<?php 
  include("header.php");
  include("library.php");
  noAccessIfLoggedIn();
?>
<div class="container">
<h1 align="center" style="font-size: 45;font-style: oblique"" >Bun venit pe pagina spitalului <h1  align="center" style="font-size: 72px;
  background: -webkit-linear-gradient(#FFB75E, #ED8F03);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight:700;
  font-style: oblique">"Raza de Soare!"</h1></h1>
    <?php include('slideshow.php');?>
  <?php 
    if(isset($_POST['lemail'])){
      $i = login($_POST['lemail'],$_POST['lpassword'],"users");
      if($i==1){
        echo '<script type="text/javascript"> window.location = "add_patient.php" </script>';
      }
    }else if(isset($_POST['remail'])){
      $i = register($_POST['remail'],$_POST['rpassword'],$_POST['rfullname'],"users");
      if($i==1){
        echo '<script type="text/javascript"> window.location = "add_patient.php"</script>';
      }
    }else{
      echo "<div class='alert alert-info'>
              <strong>Hei, salut !</strong> Logheaza-te sau inregistreaza-te pentru a putea sa te programezi la medic!</div>";
    }
    unset($_POST);
  ?>

<div class="row">
  <div class="col col-xl-6 col-sm-6">
      <h2>Login pacient</h2>
      <form action="index.php" method="POST">
        <div class="form-group">
          <label for="usr">Email:</label>
          <input type="text" class="form-control" name="lemail" required>
        </div>
        <div class="form-group">
          <label for="pwd">Parola:</label>
          <input type="password" class="form-control" name="lpassword" required>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Login">
          <input type="reset" class="btn btn-danger">
        </div>
          
      </form>
  </div>
          
  <div class="col col-xl-6 col-sm-6" id="register1">
    <form method="post" action="index.php">
	    <h2>Inregistrare pacient</h2>
	      <div class="form-group">
	        <label for="usr">Nume complet:</label>
	        <input type="text" class="form-control" name="rfullname" required>
	      </div>
        
        <div class="form-group">
	        <label for="usr">Email:</label>
	        <input type="email" class="form-control" name="remail" required>
	      </div>
	          
        <div class="form-group">
	        <label for="pwd">Parola:</label>
	        <input type="password" class="form-control"  name="rpassword" required>
	      </div>

	      <div class="form-group">
	        <input type="submit" class="btn btn-primary">
	        <input type="reset" class="btn btn-danger"></button>
	      </div>
    </form>
  </div>
</div>
</div>
<?php include("footer.php"); ?>


