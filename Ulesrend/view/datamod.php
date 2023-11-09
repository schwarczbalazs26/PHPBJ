<?php

echo '<form action="index.php" method="post" enctype="multipart/form-data">';
echo '<input type="text" name="modositandoNev" value="' . $_SESSION['nev'] . '">';
echo '<input type="submit" value="Módosítás">';
echo '<br> <input type="file" name="fileToUpload" id="fileToUpload">';
echo '</form>';
?>