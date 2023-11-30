<?php
include_once "model/osztaly.php";
$id = $_GET['id'];
$adatok = $osztaly->getUser($id);
$data = []; 
foreach($adatok as $row){
    foreach($row as $kulcs => $adat){
        $data[$kulcs] = $adat;
    }
}
echo    '<div class="col-md-6">';
echo    '<h3>Üdv ' . $data["nev"] . '!</h3>';

echo    '<img src="uploads/'. $id .'.png">';
echo    '<p> ' . ($data["sor"]+1) . '. sor ' . ($data["oszlop"]+1) . ". oszlop" . '</p>';
echo    '</div>';
?>