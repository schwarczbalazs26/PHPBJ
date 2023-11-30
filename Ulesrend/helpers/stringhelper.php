<?php

class StringHelper {

    public static function safe_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    
      public static function checkName($nev, $msg) {
        if(empty($nev)) {
            $msg .= "A névben csak space karakterek nem lehetnek. ";
        }
        if (!preg_match("/^[a-záéíóöőúüűÁÉÍÓÖŐÚÜŰA-Z-' ]*$/",$nev)) {
            $msg .= "A névben csak betűk és space karakterek lehetnek. ";
        }
        if (mb_strlen($nev) > 100) {
            $msg .= "A névben maximum 100 karakter lehet. ";
        }
        elseif (mb_strlen($nev) < 5) {
            $msg .= "A névben minimum 5 karakternek kell lennie. ";
        }
        return $msg;
    }
}

?>