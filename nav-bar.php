<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php
  $beginning = '<div class="container"><nav class="navbar navbar-default"><div class="navbar-header">
     
    </div><ul class="nav navbar-nav justified">';
  $frontLink = '<li class="nav-item"> <a class="" href="';
  $endLink = '</a></li>';

  if (isset($_SESSION['user-type'])) {
      echo $beginning;

      switch ($_SESSION['user-type']) {
      case 'doctor':

        echo $frontLink.'add_patient.php"> Adauga pacient '.$endLink;
        echo $frontLink.'patient_info.php"> Programari '.$endLink;
        break;
      case 'clerk':
        echo $frontLink.'add_patient.php"> Adauga pacient '.$endLink;
        echo $frontLink.'patient_info.php"> Programari '.$endLink;
        echo $frontLink.'showAllPatients.php"> Lista pacienti internati '.$endLink;
        echo $frontLink.'bmi.php"> Calculare indice de masa corporala'.$endLink;
        echo $frontLink.'medicament_stock.php"> Afisare stoc medicamente'.$endLink;
        echo $frontLink.'micsoreazaStocMedicamente.php"> Micsorare stoc medicamente'.$endLink;

        break;
      default:
        // code...
        break;
    }
      echo '</ul> </nav></div>';
  }

?>
