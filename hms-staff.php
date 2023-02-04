<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="jumbotron.css" rel="stylesheet">

<?php 
  include("header.php");
  include("library.php");
  noAccessIfLoggedIn();
  include("nav-bar.php");
?>
<div class="container">
<h1 align=center>Pagina de login a staff-ului.</h1>

    <?php
      if (isset($_POST['email'])){
        $type = $_POST['type'];
        $i = login($_POST['email'],$_POST['password'],$type);
        if ($i == 1){
          noAccessIfLoggedIn();
        }
      }
    ?>

<div class="row">

  <div class="col col-xl-6" align="center">
      
      <form action="hms-staff.php" method="POST">
        <div class="form-group">
          <label for="usr">Nume de utilizator:</label>
          <input type="text" class="form-control" name="email" style="width: 500;" required>
        </div>
        <div class="form-group">
          <label for="pwd">Parola:</label>
          <input type="password" class="form-control" name="password" style="width: 500;" required>
        </div>
        <div class="form-group">
          <label for="pwd">Tipul de utilizator:</label>
          <select required value=1 class ='form-control' name="type" style="width: 500;">
                <option value="admin" class="option">Administrator</option>
                <option value="clerks" class="option">Functionar</option>
                <option value="doctors" class="option">Medic</option>
          </select>
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Login">
          <input type="reset" name="" class="btn btn-danger">
        </div>
          
      </form>
  </div>
        
</div>
</div>
<?php 
include("footer.php"); ?>


