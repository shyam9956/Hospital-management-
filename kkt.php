<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>PHP Live MySQL Database Search</title>
    <style type="text/css">
    body {
        font-family: Arail, sans-serif;
    }

    /* Formatting search box */
    .search-box {
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }

    .search-box input[type="text"] {
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }

    .result {
        position: absolute;
        z-index: 999;
        top: 100%;
        left: 0;
    }

    .search-box input[type="text"],
    .result {
        width: 100%;
        box-sizing: border-box;
    }

    /* Formatting result items */
    .result p {
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }

    .result p:hover {
        background: #f2f2f2;
    }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.search-box input[type="text"]').on("keyup input", function() {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if (inputVal.length) {
                $.get("kkt.php", {
                    term: inputVal
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });
        // Set search input value on click of result item
        $(document).on("click", ".result p", function() {
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
    </script>
</head>

<body>
    <form method="POST" action="index.php">
    <div class="form-group">
    <div class="search-box">
        <input type="text" class="form-control" autocomplete="off" placeholder="Introduceti numele pacientului" name="dpatient" /> 
        <div class="result"></div>
    </div>
    </div>
    <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Calculeaza BMI-ul pacientului!">
    </div>
    </form>
    

</body>

</html>


<?php
error_reporting(E_ALL);

$conn=oci_connect("STUDENT","STUDENT","localhost/XE");
if(isset($_REQUEST['term']) and (strlen($_REQUEST['term']) >= 3)){
    if($stmt = oci_parse($conn, "SELECT full_name from patient_info where FULL_NAME like  :s and rownum<=10")){
    $param_term = '%' . $_REQUEST['term'] . '%';    
    oci_bind_by_name( $stmt , ":s" , $param_term, -1);                                                                  
        if(oci_execute($stmt)){                                                                                         
                while(($row = oci_fetch_array($stmt, OCI_BOTH)) != false) {                                                         
                    echo "<p>" . $row['FULL_NAME'] . "</p>";
                }
        } else{
            echo "ERROR: Could not able to execute" . $param_term; 
        }
    }
    oci_free_statement($stmt); 
}

if(isset($_POST['dpatient']))
{
    echo "Pacientul  ".$_POST['dpatient']."  Are BMI-ul : ";
    $full_name = $_POST['dpatient'];
    $sql = oci_parse($conn,"select * from patient_info where full_name='$full_name'");
    oci_execute($sql);
    $id_for_computing=oci_fetch_array($sql,OCI_BOTH)['PATIENT_ID'];
    echo $id_for_computing;
}


?>