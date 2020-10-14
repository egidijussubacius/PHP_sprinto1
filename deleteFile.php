<?php

$file = $_GET['name'];

unlink($file);

print "file deleted";
header("location: index.php");

?>
