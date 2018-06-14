<?php
$conn = mysqli_connect("172.17.0.1", "root", "123456", "mysql"); 

if(mysqli_connect_errno($conn)) 
{ 
    echo "连接 MySQL 失败: " . mysqli_connect_error(); 
} 

$result = mysqli_query($conn, "SELECT * FROM `user`");
$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
 
mysqli_free_result($result);
mysqli_close($conn);

echo '<pre>';
print_r($rows);
?>