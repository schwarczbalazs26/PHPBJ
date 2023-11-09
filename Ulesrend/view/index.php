<?php

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

            foreach (IMG_EXTS as $ext) {
                $imgFile = TARGET_DIR . $row["id"] . $ext;
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