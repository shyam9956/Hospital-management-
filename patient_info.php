<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="jumbotron.css" rel="stylesheet">
<?php
  include 'header.php';
  include 'library.php';
  noAccessIfNotLoggedIn();
  noAccessForNormal();
  noAccessForClerk();
  noAccessForAdmin();

  include 'nav-bar.php';
?>
<div class = 'container'>
<h2>Programari</h2>
<p>Click pe camp pentru a modifica urmatoarele informatii.</p>

<table class='table table-striped text-center '>
  <thead class="thead-inverse">
				<tr>
				<th><center>Numarul programarii</center></th>
				<th><center>Numele intreg al pacientului</center></th>
				<th><center>Conditie medicala</center></th>
                <th><center>Sugestia medicului</center></th>
				</tr>
	</thead>
<?php
error_reporting(E_ALL & ~E_NOTICE);
    $speciality = $_SESSION['speciality'];
    $result = getPatientsFor($speciality);
    oci_execute($result);

    while ($row = oci_fetch_array($result,OCI_BOTH)) {
        $status = ' ';
        if (appointment_status((int) $row['APPOINTMENT_NO']) == 1) {
            $status = 'table-active';
        } elseif (appointment_status((int) $row['APPOINTMENT_NO']) == 2) {
            $status = 'table-success';
        }

        $link = "<td ><a href= 'update_info.php?appointment_no=".$row['APPOINTMENT_NO']."'>";
        $endingTag = '</a></td>';
        echo '<tr class="'.$status.'"> ';
        echo "$link".$row['APPOINTMENT_NO']."$endingTag";
        echo "$link".$row['FULL_NAME']."$endingTag";
        echo "$link".$row['MEDICAL_CONDITION']."$endingTag";
        echo "$link".$row['DOCTORS_SUGGESTION']."$endingTag";
        echo '</tr>';
    }
?>
</table>
</div>
<?php include 'footer.php'; ?>
