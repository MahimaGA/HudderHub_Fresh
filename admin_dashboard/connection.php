<?php
    $connection = oci_connect('mahima', 'mahima', '//localhost/xe'); 
    if (!$connection) {
    $m = oci_error();
    echo "Can dfklgdflkjgv not connect to the database" .$m['message'], "\n";
    exit; } 
    //  oci_close($conn); 
?>