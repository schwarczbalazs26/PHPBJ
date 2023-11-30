<?php

  // output data of each row
  echo '<table id="terem">';
  $sorId = NULL;
  $modositandoNev = '';
  
  while($row = $result->fetch_assoc()) {
    $class = "tanulo";
    if($row['sor'] == 3 and $row['oszlop'] == 3) $class = "tanar";
    if($row["sor"] != $sorId) {
        if($sorId != NULL) echo "        </tr>";
        echo "        <tr>";
        $sorId = $row["sor"];
        $elozoOszlop = -1;
    }
    // kiírjuk az adott sor üres mezőjét
    while($row['oszlop'] != $elozoOszlop + 1) {
        echo '<td class="tolto"> </td>';
        $elozoOszlop++;
    }

    // van-e profilképe?
    
    $img = FALSE;

    foreach(IMG_EXTS as $ext) {
        $imgFile = TARGET_DIR . $row["id"].$ext;
        if (file_exists($imgFile)) {
            $img = '<img src="'.$imgFile.'?time='.time().'" style="width: 50px;"><br>';
            break;
        }
    }
    // kiírjuk az adott sor adott oszlop tanulóját
    echo '<td class="'.$class.'">';
    echo '<a href="index.php?action=user&id='.$row["id"].'">';
    if($img) echo $img;
    echo $row['nev'];
    echo '</a>';
    echo '</td>';

    if($row['sor'] == 0) {
        if($row['oszlop'] == 0) echo '<td rowspan="4" class="tolto" style="width: 40px;"></td>'; 
        //elseif($row['oszlop'] == 2) echo '<td rowspan="3" class="tolto"></td>';
    }
    $elozoOszlop = $row['oszlop'];

    if(isset($_GET['id'])) {
        if ($row["id"] == $_GET['id']) $modositandoNev = $row['nev'];
    } 
  }
?>
        </tr>
    </table>
