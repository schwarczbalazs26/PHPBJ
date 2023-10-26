<?php

require "mysql.php";
session_start();

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
    $uploadOk = 0;
    $maxFileSize = 1; //MB-ben adjuk meg
    $maxFileSize = $maxFileSize * 1024 * 1024;
    $target_dir = "uploads/";
    $imgExts = array(".jpg", ".jpeg", ".png", ".gif");

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

        $fileName = basename($_FILES["fileToUpload"]["name"]);

        $fileNameArray = preg_split("/\./", $fileName);

        $fileName = ($_SESSION['id']) . '.' . $fileNameArray[1];

        $target_file = $target_dir . $fileName;

        if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
            $msg .= "A feltöltött fájl túl nagy méretű.";
            $uploadOk = 0;
        }

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $msg .= "A feltöltött " . $_FILES["fileToUpload"]["name"] . " fájl nem kép.";
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            foreach ($imgExts as $ext) {
                $imgFile = $target_dir . $_SESSION["id"] . $ext;
                if (file_exists($imgFile)) {
                    unlink($imgFile);
                }
            }
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
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
        if ($msg == '') {
            $sql = "UPDATE osztaly SET nev = '" . $_POST['modositandoNev'] . "' WHERE id= " . $_SESSION['id'];
            if ($result = $conn->query($sql)) {
                $msg = "A név módosításra került";
            } else {
                $msg = "A név nem került módosításra.";
                if ($conn->error) {
                    echo $conn->error;
                    echo $sql;
                }
            }
        }
    }

    if (isset($_SESSION['felhasznalonev'])) {
        echo "Üdv " . $_SESSION['felhasznalonev'] . "!";
        echo ' <a href="index.php?action=logout">KILÉPÉS >> </a>';
    }

    if (isset($msg)) {
        echo "<h2>$msg</h2>";
    }


    $sql = "SELECT id, nev, sor, oszlop FROM `osztaly` ORDER BY sor, oszlop;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table id="terem">';
        $sorId = NULL;
        $modositandoNev = "";
        while ($row = $result->fetch_assoc()) {
            $class = "tanulo";
            if ($row['sor'] == 3 && $row['oszlop'] == 3) {
                $class = "tanar";
            }
            if ($row['id'] == 1) {
                $class = "sajatMagam";
            }
            if ($row['sor'] != $sorId) {
                if ($sorId != NULL) {
                    echo "</tr>";
                }
                echo "      <tr>";
                $sorId = $row["sor"];
                $elozoOszlop = -1;
            }
            //kiírjuk az adott sor üres mezejét
            while ($row['oszlop'] != $elozoOszlop + 1) {
                echo '<td class="tolto"></td>';
                $elozoOszlop++;
            }
            //van-e profilképe?
    
            $img = false;

            foreach ($imgExts as $ext) {
                $imgFile = $target_dir . $row["id"] . $ext;
                if (file_exists($imgFile)) {
                    $img = '<img src="' . $imgFile . '" style="width:50px;"><br>';
                    break;
                }
            }



            //kiírjuk az adott sor adott oszlop taunlóját
            echo '<td class="' . $class . '">';
            echo '<a href="index.php?id=' . $row["id"] . '">';
            if ($img)
                echo $img;
            echo $row['nev'];
            echo '</td>';
            if ($row['sor'] == 0) {
                if ($row['oszlop'] == 0) {
                    echo '<td rowspan="4" class="tolto" style="width 40px;"></td>';
                }
            }
            $elozoOszlop = $row['oszlop'];
            if (isset($_GET["id"])) {
                if ($row["id"] == $_GET["id"]) {
                    $modositandoNev = $row['nev'];
                }
            }
        }
    }
    ?>
    </table>
    <hr>
    <?php

    // if ($modositandoNev) {
    if (isset($_SESSION['felhasznalonev'])) {
        echo '<form action="index.php" method="post" enctype="multipart/form-data">';
        echo '<input type="text" name="modositandoNev" value="' . $_SESSION['nev'] . '">';
     //   echo '<input type="hidden" name="id" value="' . $_SESSION['id'] . '">';
        echo '<input type="submit" value="Módosítás">';
        echo '<br> <input type="file" name="fileToUpload" id="fileToUpload">';
        echo '</form>';
    } else {
        ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            Felhasználónév: <br><input type="text" name="felhasznalonev" value="" required><br>
            Jelszó: <br><input type="password" name="jelszo" required><br>
            <input type="submit" value="BELÉPÉS">
        </form>
        <?php


    }

    ?>

</body>

</html>