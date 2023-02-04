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

  noAccessForDoctor();
  noAccessForNormal();
  noAccessForAdmin();
  noAccessIfNotLoggedIn();

  include('nav-bar.php');
?>
<div class = 'container'>
<h2>Toate programarile</h2>
<p>Click pe camp pentru a modifica datele.</p>

<table class='table table-striped text-center '>
  <thead class="thead-inverse">
				<tr>
				<th><center>Numarul programarii</center></th>
				<th><center>Data internare</center></th>
				<th><center>Data externare</center></th>
				<th><center>Numele complet al pacientului</center></th>
				<!-- <th><center>Medical Condition</center></th> -->
				<th><center>Doctor necesar</center></th>
				<th><center>Total plata</center></th>
				<th><center>Caz inchis?</center></th>
				</tr>
				</thead>
<?php
error_reporting(E_ALL & ~E_NOTICE);
	$result = getAllAppointments();
	oci_execute($result);
	while($row = oci_fetch_array($result,OCI_BOTH))
	{
		$status = ' ';
		if(appointment_status((int) $row['APPOINTMENT_NO']) == 1){
			$status= "table-active";
		}else if (appointment_status((int) $row['APPOINTMENT_NO']) == 2){
			$status= "table-success";
		}

		$link = "<td ><a href= 'payment.php?appointment_no=" . $row['APPOINTMENT_NO'] . "'>";
		$endingTag = "</a></td>";
		echo "<tr class=\"" . $status . "\"> ";
		echo "$link". $row['APPOINTMENT_NO'] . "$endingTag";
		echo "$link". $row['ENTRANCE_DATE'] . "$endingTag";
		echo "$link". $row['EXIT_DATE'] . "$endingTag";
		echo "$link" . $row['FULL_NAME'] . "$endingTag";
		// echo "$link" . $row['MEDICAL_CONDITION'] . "$endingTag";
		echo "$link" . $row['SPECIALITY'] . "$endingTag";
		echo "$link" . $row['PAYMENT_AMOUNT'] . "$endingTag";
		echo "$link" . $row['CASE_CLOSED'] . "$endingTag";
		echo "</tr>";
	}
?>
</table>
</div>
<?php include("footer.php"); ?>