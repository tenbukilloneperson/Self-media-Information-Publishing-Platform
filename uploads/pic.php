<?php
// 1.接受参数
$path = $_FILES['pic']['name'];
move_uploaded_file($_FILES['pic']['tmp_name'],$path); 
echo $path;
















?>