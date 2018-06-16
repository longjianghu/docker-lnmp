<?php
$conn = mysqli_connect("172.17.0.1", "root", "123456", "mysql"); 

echo (mysqli_connect_errno($conn)) ? '数据库连接失败！' : '数据库连接成功！';

mysqli_close($conn);