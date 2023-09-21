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

    $osztaly = array(
        array("Schwarcz Balázs", "Halir Szabolcs", "Fehér László", "Gulcsik Zoltán", "Harsányi Ferenc"),
        array("Kiss Márton", "Bartha László", "Krenner Dominik", "Járfás Dániel", "Végh Szabolcs"),
        array("Bella Marcell", "Simon Attila", "", "Hadnagy Márk", "Rácz Dávid"),
        array("", "", "", "Bicsák József", "", "Topercer Márton")
    );

    ?>

    <table>
        <?php
        foreach ($osztaly as $sorIndex => $sor) {
            echo " <tr>";
            foreach ($sor as $oszlop => $nev) {
                $class = "tanulo";
                if (!$nev) {
                    $class = "tolto";
                } elseif ($sorIndex == 3 && $oszlop == 3) {
                    $class = "tanar";
                }
                echo '<td class="' . $class . '">' . $nev . '</td>';
                if ($sorIndex == 0 && $oszlop == 0) {
                    echo '<td rowspan="4" class="tolto" style="width 40px;"></td>';
                }
                if ($sorIndex == 0 && $oszlop == 2) { 
                    echo '<td rowspan="3" class="tolto"></td>';
                }
            }
            echo " </tr>";
        }
        ?>
    </table>
</body>

</html>