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

  noAccessForNormal();
  noAccessForAdmin();
  noAccessForDoctor();

  include('nav-bar.php');
?>
<div class="container">
<h2>Actualizeaza informatii despre plata</h2>
<p>Introduceti informatiile mai jos:</p>
<table class="table table-striped">
<?php



  if(isset($_POST['payment'])){
      $i = update_appointment_info($_POST['appointment_no'], 'payment_amount', $_POST['payment'], $_POST['case']);
      if($i==1){
        echo "<script type='text/javascript'>window.location = 'all_appointments.php'</script>";
      }
  }

  if(isset($_GET['appointment_no'])){
    $appointment_no = $_GET['appointment_no'];
    $result = getAllPatientDetail($appointment_no);
    oci_execute($result);

	$row = oci_fetch_array($result,OCI_BOTH);
  
    $link = "<tr><th>";
    $mid = "</th><td>";
    $endingTag = "</td></tr>";
    echo "<tr>";   // appointment_no, full_name, dob, weight, phone_no, address, blood_group, medical_condition

    echo "$link Numarul programarii  $mid". $row['APPOINTMENT_NO'] . "$endingTag";
    echo "$link Nume intreg $mid" . $row['FULL_NAME'] . "$endingTag";
    echo "$link Varsta(in ani) $mid" . $row['DOB'] . "$endingTag";

    echo "$link Greutate $mid" . $row['WEIGHT'] . "$endingTag";

    echo "$link Numar de telefon $mid" . $row['PHONE_NO'] . "$endingTag";

    echo "$link Adresa $mid" . $row['ADDRESS'] . "$endingTag";

    echo "$link Conditie medicala $mid" . $row['MEDICAL_CONDITION'] . "$endingTag";

    echo "<form action='payment.php' method='post'>";

    echo "$link Total plata $mid" . "

          <select required value=1 class ='form-control' name='payment' style='width: 500;'>
                <option value='200' class='option'>200</option>
                <option value='500' class='option'>500</option>
                <option value='900' class='option'>900</option>
          </select>

    " . "$endingTag";
    
    echo "<input type='number' style='visibility: hidden; width; 1px;' name=\"appointment_no\" value =" . $appointment_no . ">";
    
    echo "$link Caz inchis? $mid" . "

          <select required value=1 class ='form-control' name='case' style='width: 500;'>
                <option value='Da' class='option'>Da</option>
                <option value='Nu' class='option'>Nu</option>
          </select>
            <br/>
          <input type='submit' class='btn btn-primary'></form>
    
    " . "$endingTag";

    echo "</tr>";
  
  }
?>
</table>

</div>


<?php include("footer.php"); ?>


