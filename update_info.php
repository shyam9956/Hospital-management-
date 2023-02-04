<?php
    if(!isset($_SESSION))
    {
        session_start();
    }
?>
<link href="bootstrap.min.css" rel="stylesheet">
<?php
  include("header.php");
  include("library.php");
  noAccessIfNotLoggedIn();
  noAccessForNormal();
  noAccessForClerk();
  noAccessForAdmin();
  include("nav-bar.php");
?>
<div class="container">
<h2>Modifica informatiile despre pacient. </h2>
<p>Adauga informatii mai jos.</p>
<table class="table table-striped">
<?php
error_reporting(E_ALL & ~E_NOTICE);
  if(isset($_POST['upSugg'])){
      $i = update_appointment_info($_POST['appointment_no'], 'doctors_suggestion', $_POST['upSugg']);

      if($i==1){
        echo "<script type='text/javascript'>window.location = 'patient_info.php'</script>";
      }
  }

  if(isset($_GET['appointment_no'])){
    $appointment_no = $_GET['appointment_no'];
    $result = getAllPatientDetail($appointment_no);
    oci_execute($result);

    while($row = oci_fetch_array($result,OCI_BOTH))
    {
      $link = "<tr><th>";
      $mid = "</th><td>";
      $endingTag = "</td></tr>";
      echo "<tr>";   // appointment_no, full_name, dob, weight, phone_no, address, blood_group, medical_condition
      echo "$link Numarul programarii $mid". $row['APPOINTMENT_NO'] . "$endingTag";
      echo "$link Numele intreg $mid" . $row['FULL_NAME'] . "$endingTag";
      echo "$link Varsta (in ani) $mid" . $row['DOB'] . "$endingTag";
      echo "$link Greutate $mid" . $row['WEIGHT'] . "$endingTag";
      echo "$link Numar de telefon $mid" . $row['PHONE_NO'] . "$endingTag";
      echo "$link Adresa $mid" . $row['ADDRESS'] . "$endingTag";
      echo "$link Conditie medicala - $mid" . $row['MEDICAL_CONDITION'] . "$endingTag";
      echo "$link Sugestia medicului - $mid" . "<form action='update_info.php' method='post'>
      <textarea class='form-group form-control' name='upSugg' style='resize: none;'></textarea>
      <input type='number' style='visibility: hidden; width; 1px;' name='appointment_no' value =". $appointment_no . ">
      <input type='submit' class='btn btn-primary'></form>" . "$endingTag";
      echo "</tr>";
    }
  }
?>
</table>
</div>
<?php include("footer.php");?>
