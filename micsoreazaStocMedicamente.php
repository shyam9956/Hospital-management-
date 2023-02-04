<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<?php 
  include("header.php");
  include("library.php");

  noAccessForDoctor();
  noAccessForNormal();
  noAccessForAdmin();
  noAccessIfNotLoggedIn();

  include('nav-bar.php');
  error_reporting(E_ALL & ~E_NOTICE);

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="yetAnotherCss.css">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="jumbotron.css" rel="stylesheet">
</head>

<body>
    <form align=center method="post" action="micsoreazaStocMedicamente.php">
        <div class="form-group">
            <label for="pwd">Cantitate de redus:</label>
            <input style="margin-left:43.5%;" type="number" class="form-control" id="pwd" name="cantitate" min="1"
                max="1000" required>
        </div>

        <div class="form-group">
            <label for="pwd">Medicamente:</label>
            <select style="margin-left:auto;margin-right:auto;" class='form-control' required value=1 name="medicament">
                <option value="Selecteaza medicament" class="option">Selecteaza medicament</option>
                <option value="ABILIFY 1 mg/ml" class="option">ABILIFY 1 mg/ml</option>
                <option value="ZONEGRAN 100mg" class="option">ZONEGRAN 100mg</option>
                <option value="FLUOROURACIL 50mg/ml" class="option">FLUOROURACIL 50mg/ml</option>
                <option value="YASNAL 5 mg" class="option">YASNAL 5 mg</option>
                <option value="ZEBINIX" class="option">ZEBINIX</option>
                <option value="ZYPSILA 20 mg" class="option">ZYPSILA 20 mg</option>
                <option value="ZEMPLAR 1 microgram" class="option">ZEMPLAR 1 microgram</option>
                <option value="ACECLOFEN 500 mg/50 mg" class="option">ACECLOFEN 500 mg/50 mg</option>
                <option value="ZEBIZENARO 5 mgNIX" class="option">ZEBIZENARO 5 mgNIX</option>
                <option value="Paracetamol" class="option">Paracetamol</option>
                <option value="ZOMEN 7,5 mg" class="option">ZOMEN 7,5 mg</option>
                <option value="XOLAIR 150 mg" class="option">XOLAIR 150 mg</option>
                <option value="ABASAGLAR" class="option">ABASAGLAR</option>
                <option value="ACC 100 mg" class="option">ACC 100 mg</option>
                <option value="ACCUZIDE FORTE PLUS" class="option">ACCUZIDE FORTE PLUS</option>
                <option value="XYZAL 5 mg" class="option">XYZAL 5 mg</option>
                <option value="ZEPLAN 40 mg" class="option">ZEPLAN 40 mg</option>
                <option value="All" class="option">All</option>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Afiseaza stoc!">
            <input type="reset" name="" class="btn btn-danger"></button>
        </div>
    </form>

    <div class='container'>
        <table class='table table-striped text-center '>
            <thead class="thead-inverse">
                <tr>
                    <th>
                        <center>Numele medicamentului</center>
                    </th>
                    <th>
                        <center>Stoc actual</center>
                    </th>

                    </th>
                </tr>
            </thead>
    </div>





</body>

</html>

<?php 
    error_reporting(E_ALL & ~E_WARNING);
    $conn=oci_connect("STUDENT","STUDENT","localhost/XE");

    if(isset($_POST['medicament'])){
        if(isset($_POST['cantitate'])){
        $num=$_POST['medicament'];
        $cantitRed = $_POST['cantitate'];
        $sql=oci_parse($conn,'BEGIN stock_m(:nume,:cant); END;');
        oci_bind_by_name($sql , ':nume',$num);
        oci_bind_by_name($sql , ':cant',$cantitRed);
        if(oci_execute($sql))
        {
            echo status('update-success');
        }

}
        
    }
    ?>
</table>