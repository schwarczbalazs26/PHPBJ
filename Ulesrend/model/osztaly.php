<?php
class Osztaly {

    function getOsztaly() {
    
        $sql = "SELECT id, nev, sor, oszlop FROM ". DB_PREFIX . "_osztaly ORDER BY sor, oszlop;";
        $result = DataBase::$conn->query($sql);
        
        return $result;
    }

    function getUser($id) {
        $sql = "SELECT nev, sor, oszlop FROM ". DB_PREFIX . "_osztaly WHERE id =".$id;
        $result = DataBase::$conn->query($sql);
        
        return $result;
    }
    
    function updateOsztaly() {
        $sql = "UPDATE ". DB_PREFIX . "_osztaly SET nev = '".$_POST['modositandoNev']."' WHERE id = ".$_SESSION['id'];
        if($result = DataBase::$conn->query($sql)) {
            $msg = "A név módosításra került";
        }
        else {
            $msg = "A név nem került módosításra";
            if(DataBase::$conn->error) {
                echo DataBase::$conn->error;
                echo $sql;
            }
        }
        return $msg;
    }

    /**
     * ellenőrzi a felhasználót, belépteti, sessiont ír, vagy hibát ad vissza
     */
    function checkLogin($msg) {
        $sql = "SELECT jelszo, id, nev FROM ". DB_PREFIX . "_osztaly WHERE felhasznalonev = '".$_POST['felhasznalonev']."';";
        $result = DataBase::$conn->query($sql);

        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()) {
                if($row['jelszo'] == md5($_POST['jelszo'])) {
                    $_SESSION['felhasznalonev'] = $_POST['felhasznalonev'];
                    $_SESSION['nev'] = $row['nev'];
                    $_SESSION['id'] = $row['id'];
                }
                else {
                    $msg .= "A felhasználóhoz megadott jelszó nem érvényes. ";
                }
            }
        }
        else {
            $msg .= "A megadott ".$_POST['felhasznalonev']." felhasználónév nem található. ";
        }
        return $msg;
    }
}

?>