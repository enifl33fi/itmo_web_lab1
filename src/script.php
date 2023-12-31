<?php
    if (!isset($_SESSION))
    {
        session_start();
    }

    $yField = null;
    $rField = null;
    $x = null;
    if (isset($_POST['y']) && isset($_POST['r']) && isset($_POST['x'])) {
        $yField = $_POST['y'];
        $rField = $_POST['r'];
        $x = $_POST['x'];
    }
    $result = false;


    if (!isset($_SESSION['table'])) {
        $_SESSION['table'] = array();
    }

    function replaceComma($field) {
        return str_replace(",", ".", $field);
    }

    function checkY($yField): bool
    {
        if (!isset($yField)) {
            return false;
        }
        $yField = replaceComma($yField);
        return is_numeric($yField) && $yField >= -3 && $yField <= 5;
    }
    function checkR($rField): bool
    {
        if (!isset($rField)) {
            return false;
        }
        $rField = replaceComma($rField);
        return is_numeric($rField) && $rField >= 2 && $rField <= 5;
    }
    function checkX($x): bool
    {
        if (!isset($x) or empty($x) or sizeof($x) != 1 or !is_array($x)) {
            return false;
        }
        $xField = $x[0];
        return is_numeric($xField) && $xField === (string)(int)$xField && $xField >= -3 && $xField <= 5;
    }

    function checkData($x, $yField, $rField): bool
    {
        return checkX($x) && checkY($yField) && checkR($rField);
    }

    function checkInArea($x, $yField, $rField): bool
    {
        if (checkData($x, $yField, $rField)) {
            $xField = intval($x[0]);
            $yField = floatval($yField);
            $rField = floatval($rField);
            if ($xField >= 0 && $yField >= 0) {
                return ($xField <= $rField && $yField <= $rField / 2);
            } elseif ($xField >= 0 && $yField <= 0) {
                return (($yField - $xField) <= -$rField / 2);
            } elseif ($xField <= 0 && $yField <= 0) {
                return (($yField**2 + $xField**2) <= ($rField / 2) ** 2);
            }
        }
        return false;
    }
    if (checkInArea($x, $yField, $rField)) {
        $result = true;
    }
    if (checkData($x, $yField, $rField)) {
        $curDate = time();
        $scriptTime = (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) . 'с';
        array_push($_SESSION['table'], array($x[0], $yField, $rField, $curDate, $scriptTime, $result));
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Lab1</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.birds.min.js"></script>
        <script defer src="../static/js/validation.js"></script>
        <style>
            html,
            body {
                margin: 0;
                height: 100%;
                width: 100%;
            }

            body {
                box-sizing: border-box;
                background-color: #1D1E1E;
                color: #D0D0D0;
                font-family: 'Lucida Sans Unicode', 'Helvetica', sans-serif;
                font-weight: 600;
                font-size: 16px;
                padding: 12% 0;
            }

            table {
                overflow: auto;
                border:solid #D0D0D0 1px;
                border-radius: 10px;
                margin: auto;
                text-align: center;
                border-spacing: 0;
            }

            td, th {
                border-left:solid #D0D0D0 1px;
                border-top:solid #D0D0D0 1px;
                padding: 5px;
            }
            td {
                font-weight: lighter;
            }

            th {
                background-color: #141414;
            }

            th:first-of-type {
                border-top-left-radius: 8px;
            }
            th:last-of-type {
                border-top-right-radius: 8px;
            }
            tr:last-of-type td:first-of-type {
                border-bottom-left-radius: 8px;
            }
            tr:last-of-type td:last-of-type {
                border-bottom-right-radius: 8px;
            }
            .back img{
                margin-bottom: 1%;
            }


            .container {
                width: 50%;
                margin: auto;
            }
            .scroll {
                overflow: auto;
                max-height: 30vh;
            }
            .scroll::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }
            .scroll::-webkit-scrollbar-corner {
                background-color: inherit;
            }

            .scroll::-webkit-scrollbar-track {
                background-color: #1D1E1E;
                border-radius: 10px;
            }

            .scroll::-webkit-scrollbar-thumb {
                background-color: #141414;
                border-radius: 10px;
            }

            .data {
                position: relative;
                background-color: #282828;
                border-radius: 20px;
                padding: 5% 2%;
            }
        </style>
    </head>
    <body id="anim-background">
        <div class="container">
            <div class="data">
                <a href="index.html" class="back"><img src="../static/img/back.png" alt="go back"/></a>
                <div class="scroll">
                    <table>
                        <tr>
                            <th>X</th>
                            <th>Y</th>
                            <th>R</th>
                            <th>Date</th>
                            <th>Script Time</th>
                            <th>Result</th>
                        </tr>
                        <?php foreach ($_SESSION['table'] as $table): ?>
                            <tr>
                                <?php for ($i = 0; $i < count($table) - 1; $i++): ?>
                                    <td class = <?php echo "td-" . $i; ?>><?php echo $table[$i]; ?></td>
                                <?php endfor; ?>
                                <?php
                                $color = "#FF9999";
                                $text_result = "Говно, переделывай";
                                if (end($table)) {
                                    $color = "#99FF99";
                                    $text_result = "С пивом потянет";
                                }
                                ?>
                                <td style="color: <?php echo $color; ?>"><?php echo $text_result; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <script>
                            let dates = document.getElementsByClassName("td-3")
                            for (elem of dates) {
                                let curDate = new Date(elem.innerHTML * 1000);
                                elem.innerHTML = curDate.toLocaleDateString() + " " + curDate.toLocaleTimeString();
                            }
                        </script>
                    </table>
                </div>

            </div>
        </div>
        <script>
            VANTA.BIRDS({
                el: "#anim-background",
                mouseControls: true,
                touchControls: true,
                gyroControls: false,
                minHeight: 200.00,
                minWidth: 200.00,
                scale: 1.00,
                scaleMobile: 1.00,
                backgroundColor: 0xffffff,
                color1: 0x0,
                color2: 0xffffff,
                colorMode: "lerp",
                wingSpan: 13.00,
                backgroundAlpha: 0.00
            })
        </script>
    </body>
</html>
