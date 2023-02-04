<?php

$connection=oci_connect("STUDENT","STUDENT","localhost/XE");
$res=getListOfEmails('doctors');
echo $res;
while(oci_fetch_array($res,OCI_BOTH))
echo $res;

 function getListOfEmails($table)
 {
     global $connection;
     $sql =oci_parse($connection,"SELECT email FROM $table");
     oci_execute($sql);
     return oci_fetch_array($sql,OCI_BOTH)['EMAIL'];
     // $result=oci_fetch_array($sql,)
 }

?>