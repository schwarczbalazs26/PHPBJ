<?php

session_start();

define('TARGET_DIR',"uploads/");
define('IMG_EXTS', array('.jpg','.jpeg','.png','.gif'));

require "helpers/mysql.php";
$db = new DataBase;
require "model/files.php";
require "helpers/stringhelper.php";

if(isset($_GET['action'])) {
    if($_GET['action'] == 'logout') {
        session_unset(); 
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ülésrend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php

require 'controller/osztaly.php';
include 'view/menu.php';

renderView($osztaly);

?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>