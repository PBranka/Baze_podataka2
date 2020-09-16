<?php

// PHP skripta za konekciju na bazu.

$con = mysqli_connect ('localhost', 'root', '', 'bioskop');

// Ako postoji greska pri konekciji, ispisace je.
if (mysqli_connect_errno())
    print "Greska. ".mysqli_connect_error(); 

mysqli_set_charset ($con, 'utf8');

?>

