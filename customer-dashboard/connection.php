<?php
    $connection = oci_connect('HUDDERHUB_FRESH', 'TeamProj14#', '//localhost/xe'); 
    if (!$connection) {
    $m = oci_error();
    echo "Can not connect to the database" .$m['message'], "\n";
    exit; } 
?>