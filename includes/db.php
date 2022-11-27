<?php ob_start();
//več načinov povezave
// 1.
//$db_user = "localhost";  // argumente shranimo v variables in jih vstavimo v mysqli_connect()

// 2. 
// $db["db_host"] = "localhost";
// $db["db_user"] = "root";
// $db["db_password"] = "";
// $db["db_name"] = "cms";
// //     key       value
// // v array $db shranimo vse argumente in vrednosti, ki jih potrebujemo v mysqli_connect()

// foreach ($db as $key => $value) { // loopamo skozi array
//     define(strtoupper($key), $value);
// }

// $connection = mysqli_connect("DB_HOST", "DB_USER", "DB_PASSWORD", "DB_NAME");
// if ($connection) {
//     echo "We are connected";
// }

// 3.
$connection = mysqli_connect("localhost", "root", "", "cms");

$query = "SET NAMES utf8";
mysqli_query($connection, $query);

// if ($connection) {
//     echo "We are connected";
// }
