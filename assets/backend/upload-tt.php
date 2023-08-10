<?php

$fname = $_FILES['file']['tmp_name'];

$label = $_POST['label'].".pdf";
copy($fname, "../../erp/tt/$label");

echo 1;
?>