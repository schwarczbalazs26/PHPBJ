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
    require "mysql.php";
    $msg = '';
    function safe_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //ha érkezik módosításra név és id
    if (!empty($_POST['modositandoNev']) and isset($_POST['id'])) {
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
            $sql = "UPDATE osztaly SET nev = '" . $_POST['modositandoNev'] . "' WHERE id= " . $_POST['id'];
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
    /*  } else {
    $sql = "UPDATE osztaly SET nev = '" . $_POST['modositandoNev'] . "' WHERE id= " . $_POST['id'];
    if ($$msg = '') {
    $msg = "A név módosításra került.";
    } else {
    $msg = "A név nem került módosításra.";
    }
    }
    */
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

            //kiírjuk az adott sor adott oszlop taunlóját
            echo '<td class="' . $class . '">';
            echo '<a href="index.php?id=' . $row["id"] . '">' . $row['nev'] . '</a';
            echo '</td>';
            if ($row['sor'] == 0) {
                if ($row['oszlop'] == 0) {
                    echo '<td rowspan="4" class="tolto" style="width 40px;"></td>';

                    /*  } else if ($row['oszlop'] == 2) {
                    echo '<td rowspan="3" class="tolto"></td>';
                    */
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

    //adat módosító form, ha jött GET id és az létezik is
    if ($modositandoNev) {
        echo '<form action="index.php" method="post">';
        echo '<input type="text" name="modositandoNev" value="' . $modositandoNev . '">';
        echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
        echo '<input type="submit" value="Módosítás">';
        echo '</form>';
    }

    ?>

</body>

</html>