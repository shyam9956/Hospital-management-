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
  noAccessForAdmin();
  noAccessIfNotLoggedIn();
  if($_SESSION["user-type"] != 'normal'){
    include("nav-bar.php");
  }
?>
<div class="container">
    <h2>Bine ai venit, <?php echo $_SESSION["fullname"];?>!</h2>
    <h3>Te rugam sa completezi mai jos urmatoarele detalii:</h3>
    <?php
                  if(isset($_POST['apfullname'])){
                    $i = enter_patient_info($_POST['apfullname'],$_POST['apAge'],$_POST['apweight'],$_POST['apphone_no'],$_POST['apaddress'],$_POST['apheight'],$_POST['apinsurance_no']);
                    appointment_booking($i, $_POST['apSpecialist'], $_POST['apCondition']);
                    unset($_POST['apfullname']); //unset all post variables
                    if (isset($_POST['apfullname'])){
                      echo '<script type="text/javascript">location.reload();</script>';
                    }

                  }
            ?>
    <form action="add_patient.php" method="POST">

    <div class="form-group" >
              <label for="usr">Nume intreg:</label>
              <input type="text" class="form-control" id="usr" name="apfullname" required>
            </div>
            <div class="form-group">
              <label for="pwd">Varsta: (in ani)</label>
              <input type="number" class="form-control" id="pwd" name="apAge" min="1" max="200" required>
            </div>
            <div class="form-group">
              <label for="pwd">Greutate (in kg):</label>
              <input type="tel" class="form-control" id="pwd" name="apweight" min="1" max="300" required>
            </div>
            <div class="form-group">
              <label for="pwd">Inaltime(in centimetri):</label>
              <input type="tel" class="form-control" id="pwd" name="apheight" min="1" max="300" required>
            </div>
            <div class="form-group">
              <label for="pwd">Numar de telefon:</label>
              <input type="tel" class="form-control" id="pwd" name="apphone_no" required>
            </div>
            <div class="form-group">
              <label for="pwd">Addresa:</label>
              <textarea class="form-control" id="pwd" name="apaddress" required></textarea>
            </div>
            <div class="form-group">
              <label for="pwd">Numar de asigurare:</label>
              <input type="tel" class="form-control" id="pwd" name="apinsurance_no" required>
            </div>
            

            <div class="form-group">
              <label for="pwd">De ce doctor ai nevoie?</label>
              <select required value=1 name="apSpecialist">
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
              <label for="pwd">Conditie medicala / Motivul vizitarii spitalului:</label>
              <textarea class="form-control" id="pwd" name="apCondition" required></textarea>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-primary" >
              <input type="reset" name="" class="btn btn-danger">
            </div>
          </form>
</div>
<?php
  include("footer.php");
?>
