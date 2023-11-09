<?php

function getOsztaly($conn){

    $sql = "SELECT id, nev, sor, oszlop FROM `osztaly` ORDER BY sor, oszlop;";
    $result = $conn->query($sql);
    
    return $result;
}

function updateOsztaly($conn){

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
            return $msg;
        }

?>