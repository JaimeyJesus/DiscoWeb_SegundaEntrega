<?php
$enlace=$userId."/".$archivo;
header("Content-disposition: attachment; filename=$archivo");
header("Content-type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
?>