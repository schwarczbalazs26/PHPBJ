<?php

session_start();

define('TARGET_DIR',"uploads/");
define('IMG_EXTS', array('.jpg','.jpeg','.png','.gif'));

require "mysql.php";
require "model/files.php";

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
    <title>Ülésrend</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<?php

function safe_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$msg = ''; 


if(isset($_POST['felhasznalonev']) and isset($_POST['jelszo'])) {
    // ha érkezik login adat
    if(empty($_POST['felhasznalonev'])) $msg .= "A felhasználónév nem került megadásra. ";
    if(empty($_POST['jelszo'])) $msg .= "A jelszó nem került megadásra. ";
    if(!$msg) {
        $sql = "SELECT jelszo, id, nev FROM osztaly WHERE felhasznalonev = '".$_POST['felhasznalonev']."';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                if($row['jelszo'] == md5($_POST['jelszo'])) {
                    $_SESSION['felhasznalonev'] = $_POST['felhasznalonev'];
                    $_SESSION['nev'] = $row['nev'];
                    $_SESSION['id'] = $row['id'];
                }
                else {
                    $msg .= "A felhasználóhoz megadott jelszó nem érvényes. ";
                }
            }
        }
        else {
            $msg .= "A megadott ".$_POST['felhasznalonev']." felhasználónév nem található. ";
        }
    }
}
// ha érkezik módosításra név és id
elseif(isset($_POST['modositandoNev']) and isset($_SESSION['id'])) {

    if(!empty($_FILES["fileToUpload"]["name"])) {
        $msg = fileUpload($msg);
    }

    $nev = safe_input($_POST['modositandoNev']);

    if(empty($nev)) {
        $msg .= "A névben csak space karakterek nem lehetnek. ";
    }
    if (!preg_match("/^[a-záéíóöőúüűÁÉÍÓÖŐÚÜŰA-Z-' ]*$/",$nev)) {
        $msg .= "A névben csak betűk és space karakterek lehetnek. ";
    }
    if (mb_strlen($nev) > 100) {
        $msg .= "A névben maximum 100 karakter lehet. ";
    }
    elseif (mb_strlen($nev) < 5) {
        $msg .= "A névben minimum 5 karakternek kell lennie. ";
    }

    if ($msg == '') {
        require "model/osztaly.php";
        $msg = updateOsztaly($conn);
    }
}
echo '<a href="index.php"> ÜLÉSREND </a> | ';
if(isset($_SESSION['felhasznalonev'])) {
    echo '<a href="index.php?action=datamod"> ADATMÓDOSÍTÁS </a> | ';
    echo "ÜDV ".$_SESSION['felhasznalonev']."! ";
    echo '<a href="index.php?action=logout">KILÉPÉS >> </a>';
}
else echo '<a href="index.php?action=login"> BELÉPÉS </a>';

if(isset($msg)) echo "<h2>$msg</h2>";

$action = $_GET['action'] ?? FALSE;

switch($action) {
    case 'login':
        include "view/login.php";
    break;

    case 'datamod':
        include "view/datamod.php";
    break;

    default:
        require_once "model/osztaly.php";
        $result = getOsztaly($conn);
        if ($result->num_rows > 0) {
            include "view/index.php";
        }
}

?>
</body>
</html>