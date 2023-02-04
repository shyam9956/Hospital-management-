<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<?php
    $connection=oci_connect("STUDENT","STUDENT","localhost/XE");

    $error_flag = 0;
    $result;

    function secure($unsafe_data)
    {
        // if(strstr($unsafe_data,'drop')||strstr($unsafe_data,'select')||strstr($unsafe_data,'update')||
        // strstr($unsafe_data,'insert')||strstr($unsafe_data,'delete')||strstr($unsafe_data,'table'))
        // {
        //    header("Location: http://localhost/Hospital-Management-master/injection.php", true, 301);
        //     exit();
        // }
        // else
        // {
        //     return htmlentities($unsafe_data);
        // }
        return htmlentities($unsafe_data);
    }

    function login($email_id_unsafe, $password_unsafe, $table = 'users')
    {
        global $connection;

        $email_id = secure($email_id_unsafe);
        $password = secure($password_unsafe);

        $sql=oci_parse($connection,"SELECT COUNT(*) FROM $table WHERE email = '$email_id' AND password = '$password'");
        oci_execute($sql);
        $num_rows =oci_fetch_array($sql,OCI_BOTH);

        if ($num_rows[0] == 0) {
            echo status('no-match');
            return 0;
        } else {
            echo "<div class='alert alert-success'> <strong>Well done!</strong> Logged In</div>";
            $_SESSION['username'] = $email_id;

            if ($table == 'admin') {
                $_SESSION['user-type'] = 'admin';
            }

            if ($table == 'users' || $table == 'doctors' || $table == 'clerks') {

                $sql=oci_parse($connection,"SELECT fullname FROM $table WHERE email = '$email_id' AND password = '$password'");
                oci_execute($sql);
                $fullname = oci_fetch_array($sql,OCI_BOTH);

                $_SESSION['fullname'] = $fullname['FULLNAME'];
                if ($table == 'users') {
                    $_SESSION['user-type'] = 'normal';
                } elseif ($table == 'clerks') {
                    $_SESSION['user-type'] = 'clerk';
                } else {
                    $_SESSION['user-type'] = 'doctor';

                    $sqldoc=oci_parse($connection,"SELECT speciality FROM $table WHERE email = '$email_id' AND password = '$password'");
                    oci_execute($sqldoc);
                    $speciality = oci_fetch_array($sqldoc,OCI_BOTH)[0];
                    $_SESSION['speciality'] = $speciality;
                }
            }

            return 1;
        }
    }

    function register($email_id_unsafe, $password_unsafe, $full_name_unsafe, $speciality_unsafe = 'doctor', $table = 'users')
    {
        global $connection,$error_flag;

        $email = secure($email_id_unsafe);
        $password = secure($password_unsafe);
        $speciality = secure($speciality_unsafe);
        $fullname = ucfirst(secure($full_name_unsafe));
        $verifyEmail = oci_parse($connection, "select count(*) from $table where email = '$email'");
        oci_execute($verifyEmail);
        $aux=oci_fetch_array($verifyEmail, OCI_BOTH)[0];

        if($aux > 1)
        {
            echo status('already-existent');
            return 0;
        }else{
        $sql;

        switch ($table) {
            case 'users':
                $sql =oci_parse($connection,"INSERT INTO $table VALUES ('$email', '$password', '$fullname')");
                if(oci_execute($sql))
                echo status('record-success');
                else
                echo status('already-existent');
                break;
            case 'doctors':
                $sql =oci_parse($connection,"INSERT INTO $table VALUES ('$email', '$password', '$fullname','$speciality')");
                if(oci_execute($sql))
                echo status('record-success');
                else
                echo status('already-existent');
                break;
            case 'clerks':
                $sql =oci_parse($connection,"INSERT INTO $table VALUES ('$email', '$password', '$fullname')");
                if(oci_execute($sql))
                echo status('record-success');
                else
                echo status('already-existent');                
                break;
            default:
                // code...
                break;
        }

            if ($table == 'users') {
                return login($email, $password);
            }
        }
    }

    function status($type, $data = 0)
    {
        $success = "<div class='alert alert-success'> <strong>Super!</strong>";
        $fail = "<div class='alert alert-warning'><strong>Ne pare rau dar...</strong>";
        $end = '</div>';

        switch ($type) {
            case 'record-success':
                return "$success Instanta noua creata cu succes! $end";
                break;
            case 'record-fail':
                return "$fail nu am putut crea instanta. $end";
                break;
            case 'record-dup':
                return "$fail exista aceste date deja. $end";
                break;
            case 'no-match':
                return "$fail datele nu se potrivesc. $end";
                break;
            case 'con-failed':
                return "$fail conexiunea a picat. $end";
                break;
            case 'appointment-success':
                return "$success Programarea a fost facuta cu succes! Numarul programarii tale este:  $data $end";
                break;
            case 'appointment-fail':
                return "$fail nu am reusit sa iti facem programarea. $end";
                break;
            case 'update-success':
                return "$success Instanta a fost modificata cu succes! $end";
                break;
            case 'update-fail':
                return "$fail nu am reusit sa modificam datele. $end";
                break;
            case 'already-existent':
                return "$fail Email-ul este deja existent! Te rugam sa alegi altul. $end";
                break;
            case 'stoc_redus':
                return "$fail Stocul din acest medicament este redus! $end";
                break;
            default:
                // code...
                break;
        }
    }

  function enter_patient_info($full_name_unsafe, $age_unsafe, $weight_unsafe, $phone_no_unsafe, $address_unsafe, $height_unsafe, $insurance_no_unsafe)
  {
    global $connection, $error_flag,$result;

    $full_name = ucfirst(secure($full_name_unsafe));
    $age = secure($age_unsafe);
    $weight = secure($weight_unsafe);
    $height = secure($height_unsafe);
    $phone_no = secure($phone_no_unsafe);
    $address = secure($address_unsafe);
    $insurance_no = secure($insurance_no_unsafe);
    $sql= oci_parse($connection, "select sysdate from dual");
    oci_execute($sql);
    $entrance_date = oci_fetch_array($sql)[0];
    //data internare,externare, id;




    $sql= oci_parse($connection,"select max(patient_id) from patient_info");
    oci_execute($sql);
    $max_id=(int) oci_fetch_array($sql,OCI_BOTH)[0];
    $max_id++;
    echo $max_id;
    $sql =oci_parse($connection,"INSERT INTO patient_info VALUES ('$max_id', '$full_name', '$insurance_no', '$age', '$weight', '$height', '$phone_no', '$address', '$entrance_date', null)");
    if (oci_execute($sql)) {
        echo status('record-success');
        return $max_id;
    } else {
        echo status('record-fail');
        return 0;
    }
  }

    function appointment_booking($patient_id_unsafe, $specialist_unsafe, $medical_condition_unsafe)
    {
        global $connection;
        $patient_id = secure($patient_id_unsafe);
        $specialist = secure($specialist_unsafe);
        $medical_condition = secure($medical_condition_unsafe);
        $sql= oci_parse($connection,"select max(APPOINTMENT_NO) from appointments");
        oci_execute($sql);
        $max_app_no =(int) oci_fetch_array($sql,OCI_BOTH)[0];
        ++$max_app_no;
        $sql =oci_parse($connection,"INSERT INTO appointments VALUES ('$max_app_no', '$patient_id', '$specialist', '$medical_condition', NULL, NULL, 'Nu')");
        if (oci_execute($sql)) {
            echo status('appointment-success', $max_app_no);
        } else {
            echo status('appointment-fail');
            echo 'Error: '.$sql.'<br>'.$connection->error;
        }
    }

    function update_appointment_info($appointment_no_unsafe, $column_name_unsafe, $data_unsafe, $case_unsafe='Nu')
    {
        global $connection;

        $appointment_no = (int) secure($appointment_no_unsafe);
        $column_name = secure($column_name_unsafe);
        $data = secure($data_unsafe);
        $case = secure($case_unsafe);

        $sql= oci_parse($connection, "select sysdate from dual");
        oci_execute($sql);
        $exit_date = oci_fetch_array($sql)[0];

        $sql=oci_parse($connection, "select patient_id from appointments where appointment_no= :appointmentNo");
        oci_bind_by_name($sql, ':appointmentNo', $appointment_no);
        oci_execute($sql);
        $patient_id_aux = oci_fetch_array($sql,OCI_BOTH)[0];

        $sql = oci_parse($connection, "select case_closed from appointments where APPOINTMENT_NO= :appointmentNo");
        oci_bind_by_name($sql, ':appointmentNo', $appointment_no);
        oci_execute($sql);
        $aux = oci_fetch_array($sql, OCI_BOTH)[0];
        if($aux == 'Nu' && $case == 'Da')
        {
            $sql = oci_parse($connection, "update patient_info set EXIT_DATE='$exit_date' where patient_id ='$patient_id_aux'");
            oci_execute($sql);
        }

        if ($column_name == 'payment_amount') {
            $data = (int) $data;
            $sql = oci_parse($connection,"UPDATE appointments SET payment_amount = :data, case_closed = :case WHERE appointment_no = :appointmentNo");
            oci_bind_by_name($sql, ':data', $data);
            oci_bind_by_name($sql, ':case', $case);
            oci_bind_by_name($sql, ':appointmentNo', $appointment_no);

        } else {
            $sql = oci_parse($connection,"UPDATE appointments SET $column_name = :data WHERE appointment_no = :appointmentNo");
            oci_bind_by_name($sql, ':appointmentNo', $appointment_no);
            oci_bind_by_name($sql, ':data', $data);
        }
        if (oci_execute($sql)) {
            echo status('update-success');
            return 1;
        } else {
            echo status('update-fail');
            echo 'Error: '.$sql.'<br>'.$connection->error;
            return 0;
        }
    }

    function getPatientsFor($doctor)
    {
        global $connection;

        return oci_parse($connection,"SELECT appointment_no, full_name, medical_condition, doctors_suggestion FROM patient_info, appointments where speciality='$doctor' AND patient_info.patient_id = appointments.patient_id");
    }

    function getAllAppointments()
    {
        global $connection;
        return oci_parse($connection,"SELECT appointment_no, entrance_date, exit_date , full_name,speciality, case_closed, payment_amount FROM patient_info, appointments where patient_info.patient_id = appointments.patient_id");
    }

    function getAllPatientDetail($appointment_no)
    {
        global $connection;
        return oci_parse($connection,"SELECT appointment_no, full_name, dob, weight, phone_no, address, medical_condition FROM patient_info, appointments where appointment_no=$appointment_no AND patient_info.patient_id = appointments.patient_id");
    }

    function appointment_status($appointment_no_unsafe)
    {
        global $connection;

        $appointment_no = secure($appointment_no_unsafe);
        $i = 0;
        $result =oci_parse($connection,"SELECT doctors_suggestion FROM appointments WHERE appointment_no=$appointment_no");
            oci_execute($result);
        if ($result === false) {
            return 0;
        } else {
            ++$i;
        }

        $result =oci_parse($connection,"SELECT payment_amount FROM appointments WHERE appointment_no=$appointment_no");
            oci_execute($result);
        if (oci_num_rows($result) == 1) {
            ++$i;
        }

        return $i;
    }

    function delete($table, $id_unsafe)
    {
        global $connection;

        $id = secure($id_unsafe);

        $sql =oci_parse($connection,"DELETE FROM $table WHERE email='$id'");
        oci_execute($sql);
    }

    function getListOfEmails($table)
    {
        global $connection;
        return oci_parse($connection,"SELECT email FROM $table");
    }

    function noAccessForNormal()
    {
        if (isset($_SESSION['user-type'])) {
            if ($_SESSION['user-type'] == 'normal') {
                echo '<script type="text/javascript">window.location = "add_patient.php"</script>';
            }
        }
    }
    function noAccessForDoctor()
    {
        if (isset($_SESSION['user-type'])) {
            if ($_SESSION['user-type'] == 'doctor') {
                echo '<script type="text/javascript">window.location = "patient_info.php"</script>';
            }
        }
    }
    function noAccessForClerk()
    {
        if (isset($_SESSION['user-type'])) {
            if ($_SESSION['user-type'] == 'clerk') {
                echo '<script type="text/javascript">window.location = "all_appointments.php"</script>';
            }
        }
    }

    function noAccessForAdmin()
    {
        if (isset($_SESSION['user-type'])) {
            if ($_SESSION['user-type'] == 'admin') {
                echo '<script type="text/javascript">window.location = "admin_home.php"</script>';
            }
        }
    }

    function noAccessIfLoggedIn()
    {
        if (isset($_SESSION['user-type'])) {
            noAccessForNormal();
            noAccessForAdmin();
            noAccessForClerk();
            noAccessForDoctor();
        }
    }

    function noAccessIfNotLoggedIn()
    {
        if (!isset($_SESSION['user-type'])) {
            echo '<script type="text/javascript">window.location = "index.php"</script>';
        }
    }

?>