<?php
$server = "localhost"; //主机
$db_username = "root"; //你的数据库用户名
$db_password = "1657181739"; //你的数据库密码
$mysqli = new mysqli($server, $db_username, $db_password, "test");
// if (mysqli_connect_errno()) {
//     printf("Connect failed: %s\n", mysqli_connect_errno());
//     exit();
// } else {
//     printf("Host information: %s\n", mysqli_get_host_info($mysqli));
// }
// mysqli_close($mysqli);
