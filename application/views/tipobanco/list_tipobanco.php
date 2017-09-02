<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Banco</th>
			<th>Agencia</th>
			<th>Conta Corrente</th>
			<th>Nome do Favorecido</th>
            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        if ($q) {

            foreach ($q as $row)
            {

                $url = base_url() . 'tipobanco/alterar/' . $row['idTab_TipoBanco'];
                #$url = '';

                echo '<tr class="clickable-row" data-href="' . $url . '">';
                    echo '<td>' . $row['TipoBanco'] . '</td>';
					echo '<td>' . $row['AgTipoBanco'] . '</td>';
					echo '<td>' . $row['ContaTipoBanco'] . '</td>';
					echo '<td>' . $row['NomeTipoBanco'] . '</td>';
                    #echo '<td>' . str_replace('.',',',$row['ValorVenda']) . '</td>';
                    echo '<td></td>';
                echo '</tr>';            

                $i++;
            }
            
        }
        ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total encontrado: <?php echo $i; ?> resultado(s)</th>
        </tr>
    </tfoot>
</table>



