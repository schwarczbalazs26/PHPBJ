<div class="col-md-2">
<?php

    echo '<form action="index.php" method="post" enctype="multipart/form-data">';
    echo '  <input type="text" class="form-control" name="modositandoNev" value="'.$_SESSION['nev'].'">';
    echo '  <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">';
    echo '  <input type="submit" value="MÓDOSÍTÁS" class="btn btn-primary">';
    echo '</form>';

?>
</div>