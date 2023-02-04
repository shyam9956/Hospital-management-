<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="jumbotron.css" rel="stylesheet">
<link href="yetAnotherCss.css" rel="stylesheet">
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
<div class = 'container'>
<table class='table table-striped text-center '>
  <thead class="thead-inverse">
				<tr>
                <th><center>Numar ordine</center></th>
				<th><center>Nume pacient</center></th>
				<th><center>Numar de asigurare</center></th>
				<th><center>Varsta</center></th>
				<th><center>Nr. Telefon</center></th>
                <th><center>Data internare</center></th>
				<th><center>Data externare</center></th>
				<th><center>Adresa</center></th>
				</tr>
				</thead>
<?php
try {

$con = oci_connect("STUDENT","STUDENT","localhost/XE");
$sql = oci_parse($con,"SELECT COUNT(*)FROM patient_info");
            oci_execute($sql);
            $fetchresult = oci_fetch_array($sql,OCI_BOTH)[0];
            $total = $fetchresult;

$limit = 10;
$pages = ceil($total / $limit);
$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
    'options' => array(
        'default'   => 1,
        'min_range' => 1,
    ),
)));
$offset = ($page - 1)  * $limit;
$start = $offset + 1;
$end = min(($offset + $limit), $total);
$prevlink = ($page > 1) ? '<a style="color:yellow; font-size:30px;" href="?page=1" title="First page">&laquo;</a> <a style="color:yellow; font-size:30px;" href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
$nextlink = ($page < $pages) ? '<a style="color:yellow; font-size:30px;" href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a style="color:yellow; font-size:30px;" href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
echo '<div id="paging" style="margin-left:27%; font-weight: 700; color:black;"><p>', $prevlink, ' Pagina ', $page, ' din ', $pages, ' de pagini, afiseaza intre ', $start, '-', $end, ' din ', $total, ' de rezultate ', $nextlink, ' </p></div>';



$sql = oci_parse($con,"SELECT * FROM (
    SELECT
      ord.*,
      row_number() over (ORDER BY ord.patient_id ASC) line_number
    FROM patient_info ord
  ) WHERE line_number BETWEEN $start AND $end  ORDER BY line_number");
oci_execute($sql);



while($fetch = oci_fetch_array($sql,OCI_BOTH)){
    $fullName = $fetch['FULL_NAME'];
    $adress = $fetch['ADDRESS'];
    $insNumber = $fetch['INSURANCE_NO'];
    $age = $fetch['DOB'];
    $phone = $fetch['PHONE_NO'];
    $entrDate = $fetch['ENTRANCE_DATE'];
    $exitDate = $fetch['EXIT_DATE'];
    $sno=$fetch['PATIENT_ID'];
    ?>
<tr>
    <td align='center'><?php echo $sno; ?></td>
    <td align='center'><?php echo $fullName; ?></td>
    <td align='center'><?php echo $insNumber; ?></td>
    <td align='center'><?php echo $age; ?></td>
    <td align='center'><?php echo $phone; ?></td>
    <td align='center'><?php echo $entrDate; ?></td>
    <td align='center'><?php echo $exitDate; ?></td>
    <td align='center'><?php echo $adress; ?></td>

</tr>
<?php
}

} catch (Exception $e) {
echo '<p>', $e->getMessage(), '</p>';
}

?>
</div>
</table>
<?php include('footer.php');?>


