<?php

    echo '<form action="index.php" method="post" enctype="multipart/form-data">';
    echo '  <input type="text" name="modositandoNev" value="'.$_SESSION['nev'].'">';
    echo '  <input type="file" name="fileToUpload" id="fileToUpload">';
    //echo '  <input type="hidden" name="id" value="'.$_SESSION['id'].'">';
    echo '  <input type="submit" value="MÓDOSÍTÁS">';
    echo '</form>';

?>