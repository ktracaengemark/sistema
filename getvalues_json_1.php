<!DOCTYPE html>
<html>
    <head>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid black;
                padding: 5px;
            }

            th {text-align: left;}
        </style>
    </head>
    <body>

        <?php
        $q = intval($_GET['q']);

        session_start();        
        
        $con = mysqli_connect('159.203.125.243', 'usuario', '20UtpJ15');
        if (!$con) {
            die('Não foi possível conectar: ' . mysql_error());
        }

        mysqli_select_db($con, "app");
        $sql = "SELECT * FROM App_Servico WHERE idApp_Servico = '" . $q . "'";
        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . str_replace('.', ',', $row['ValorServico']) . "</td>";
            echo "</tr>";
        }
        mysqli_close($con);
        ?>
    </body>
</html>