<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<?php 
  include("header.php");
  include("library.php");

  noAccessForClerk();
  noAccessForDoctor();
  noAccessForNormal();

  noAccessIfNotLoggedIn();

?>
<div class="container">
<h1 align=center>Admin Logat cu succes!</h1>

    <?php 
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    if(isset($_POST['demail'])){
      $i = register($_POST['demail'],$_POST['dpassword'],$_POST['dfullname'],$_POST['dSpecialist'],"doctors");
      unset($_POST);
    }
    if(isset($_POST['aemail'])){
      $i = register($_POST['aemail'],$_POST['apassword'],$_POST['afullname'],'non',"clerks");
      unset($_POST);
    }
    if(isset($_POST['DrDelEmail'])){
      $i = delete("doctors",$_POST['DrDelEmail']);
      unset($_POST);
    }
    if(isset($_POST['ClDelEmail'])){
      $i = delete("clerks",$_POST['ClDelEmail']);
      unset($_POST);
    }
    
  ?>


<div class="col col-xl-6 col-sm-6" id="register1">
    <form method="post" action="admin_home.php">
      <h2>Inregistrare functionari</h2>
        <div class="form-group">
          <label for="usr">Nume intreg:</label>
          <input type="text" class="form-control" name="afullname" required>
        </div>
        
        <div class="form-group">
          <label for="usr">Email:</label>
          <input type="email" class="form-control" name="aemail" required>
        </div>
            
        <div class="form-group">
          <label for="pwd">Parola:</label>
          <input type="password" class="form-control"  name="apassword" required>
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Inregistrare">
          <input type="reset" name="" class="btn btn-danger"></button>
        </div>
    </form>
      <hr>
                  <form method="post" action="admin_home.php">

      <div class="form-group">
                <h2>Sterge functionari</h2>
            <select class='form-control' required value=1 name="ClDelEmail">    
                    <?php 
                $result = getListOfEmails('clerks');
                oci_execute($result);

                if(is_bool($result)){
                  echo "No doctors found in database";
                }else{
                  while($row = oci_fetch_array($result,OCI_BOTH))
                  {
                    echo "<option value='" . $row['EMAIL'] . "'>" . $row['EMAIL'] . "</option>";
                  }
                  echo '&emsp;';

                }

            ?>
                </select>
            </div>
            <div class="form-group">

                <input type="submit" class="btn btn-primary" style="padding: 10px;" value="Delete">
            </div>
        </form>
    </div>

    <div class="col col-xl-6 col-sm-6 " id="register1">
    <form method="post" action="admin_home.php">
      <h2>Inregistreaza doctori</h2>
        <div class="form-group">
          <label for="usr">Nume intreg:</label>
          <input type="text" class="form-control" name="dfullname" required>
        </div>
        
        <div class="form-group">
          <label for="usr">Email:</label>
          <input type="email" class="form-control" name="demail" required>
        </div>
            
        <div class="form-group">
          <label for="pwd">Parola:</label>
          <input type="password" class="form-control"  name="dpassword" required>
        </div>

        <div class="form-group">
          <label for="pwd">Specialitate:</label>
            <select class='form-control' required value=1 name="dSpecialist">
            <option value="Neurolog" class="option">Neurolog</option>
                <option value="Chirurg" class="option">Chirurg </option>
                <option value="Oftalmolog" class="option">Oftalmolog </option>
                <option value="Endocrinolog" class="option">Endocrinolog </option>
                <option value="Ortoped" class="option">Ortoped</option>
                <option value="Urolog" class="option">Urolog</option>
                <option value="Cardiolog" class="option">Cardiolog</option>
                <option value="Oncolog" class="option">Oncolog</option>
                <option value="Medic Intern" class="option">Medic Intern</option>
                <option value="Reumatolog" class="option">Reumatolog</option>
                <option value="Hematolog" class="option">Hematolog</option>
            </select>
        </div>

        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Inregistrare">
          <input type="reset" name="" class="btn btn-danger"></button>
        </div>
    </form>


        <hr>
                    <form method="post" action="admin_home.php">

        <div class="form-group">
                <h2>Sterge doctor</h2>
            <select class='form-control' required value=1 name="DrDelEmail">

                    <?php 
                $result = getListOfEmails('doctors');
                oci_execute($result);

                if(is_bool($result)){
                  echo "No doctors found in database";
                }else{
                  while($row = oci_fetch_array($result,OCI_BOTH))
                  {
                    echo "<option value='" . $row['EMAIL'] . "'>" . $row['EMAIL'] . "</option>";
                  }
                  echo '&emsp;';

                }

            ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Delete">
            </div>
        </form>
    </div>
    </form>
</div>
</div>


</div>
<div class="col col-xl-6 col-sm-6 " id="register1">
</div>
<div class="col col-xl-6 col-sm-6 " id="register1">
</div>
<?php include("footer.php"); ?>