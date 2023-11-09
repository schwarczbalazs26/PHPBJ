<?php
session_start();

define ('TARGET_DIR','uploads/');
define ('IMG_EXTS',array('.jpg', 'jpeg', '.png', '.gif', '.jfif'));

require "mysql.php";
require "model/files.php";


if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        session_unset();
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ulesrend.css">
    <title>Ülésrend</title>

</head>

<body>

    <?php
    $msg = '';

    function safe_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //ha érkezik login adat
    if (isset($_POST['felhasznalonev']) and isset($_POST['jelszo'])) {
        if (empty($_POST['felhasznalonev'])) {
            $msg .= "A felhasználónév nem került megadásra.";
        }
        if (empty($_POST['jelszo'])) {
            $msg .= "A jelszó nem került megadásra.";
        }
        if (!$msg) {
            $sql = "SELECT jelszo, id, nev FROM osztaly WHERE felhasznalonev = '" . $_POST['felhasznalonev'] . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['jelszo'] == md5($_POST['jelszo'])) {
                        $_SESSION['felhasznalonev'] = $_POST['felhasznalonev'];
                        $_SESSION['nev'] = $row['nev'];
                        $_SESSION['id'] = $row['id'];
                    } else {
                        $msg .= "A felhasználóhoz megadott jelszó nem helyes.";
                    }
                }
            } else {
                $msg .= "A megadott " . $_POST['felhasznalonev'] . " felhasználónév nem található.";
            }
        }

    }
    //ha érkezik módosításra név és id
    elseif (isset($_POST['modositandoNev']) and isset($_SESSION['id'])) {

        if(!empty($_FILES["fileToUpload"]["name"])){
            $msg = fileUpload($msg);
        }

        $nev = safe_input(($_POST['modositandoNev']));
        if (!preg_match(" /^[a-záéíóöőúüűÁÉÍÓÖŐÚÜŰA-Z-' ]*$/", $nev)) {
            $msg .= " A névben csak betűk és space karakterek lehetnek.";
        }
        if (mb_strlen($nev) > 100) {
            $msg .= " A név max 100 karakter lehet.";
        } elseif (mb_strlen($nev) < 5) {
            $msg .= " A névben minimum 5 karakternek kell lennie.";
        }
        if (empty($nev)) {
            $msg = " Csak space nem lehet a névben.";
        }
        if($msg == ''){
            include "model/osztaly.php";
            $msg = updateOsztaly($conn);
        }
    }

    echo '<a href="index.php">ÜLÉSREND</a> | ';

    if (isset($_SESSION['felhasznalonev'])) {
        echo ' <a href="index.php?action=datamod">ADATMÓDOSÍTÁS</a> | ';
        echo "Üdv " . $_SESSION['felhasznalonev'] . "!";
        echo ' <a href="index.php?action=logout">KILÉPÉS>> </a>';
    }
    else{
        echo ' <a href="index.php?action=login"> BELÉPÉS </a>';
    }

    if (isset($msg)) {
        echo "<h2>$msg</h2>";
    }
    ?>
    <hr>
    <?php
    
    if (isset($_SESSION['felhasznalonev'])) {
        include "view/datamod.php";
    } else {
        include "view/login.php";
    }

    $action = $_GET['action'] ?? FALSE;

    switch ($action){
        case 'login':
            include_once "view/login.php";
        break;
        case 'datamod':
            include_once "view/datamod.php";
        break;
    
        default:
            require_once "model/osztaly.php";
            $result = getOsztaly($conn);
            if ($result-> num_rows > 0) {
                include "view/index.php";
    }
}

    ?>

</body>

</html>