<div style="overflow: auto; height: 190px;">
	<div class="container-fluid">
		<div class="row">

			<table class="table table-bordered table-condensed table-striped">

				<thead>
					<tr>
						<th class="active text-center">Diario</th>
						<th class="active text-center">01</th>
						<th class="active text-center">02</th>
						<th class="active text-center">03</th>
						<th class="active text-center">04</th>
						<th class="active text-center">05</th>
						<th class="active text-center">06</th>
						<th class="active text-center">07</th>
						<th class="active text-center">08</th>
						<th class="active text-center">09</th>
						<th class="active text-center">10</th>
						<th class="active text-center">11</th>
						<th class="active text-center">12</th>
						<th class="active text-center">13</th>
						<th class="active text-center">14</th>
						<th class="active text-center">15</th>
						<th class="active text-center">16</th>
						<th class="active text-center">17</th>
						<th class="active text-center">18</th>
						<th class="active text-center">19</th>
						<th class="active text-center">20</th>
						<th class="active text-center">21</th>
						<th class="active text-center">22</th>
						<th class="active text-center">23</th>
						<th class="active text-center">24</th>
						<th class="active text-center">25</th>
						<th class="active text-center">26</th>
						<th class="active text-center">27</th>
						<th class="active text-center">28</th>
						<th class="active text-center">29</th>
						<th class="active text-center">30</th>
						<th class="active text-center">31</th>
						<th class="active text-center">TOTAL</th>
					</tr>
				</thead>

				<tbody>

					<tr>
						<?php
						echo '<td><b>' . $report['RecVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=31;$i++) {
							echo '<td class="text-left">' . $report['RecVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralvenc']->RecVenc . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['RecPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=31;$i++) {
							$bgcolor = ($report['RecPago'][0]->{'M'.$i} <= 0) ? 'bg-success' : 'bg-success';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['RecPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->RecPago <= 0) ? 'bg-success' : 'bg-success';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralpago']->RecPago . '</td>';
						?>
					</tr>
					
					<tr>
						<?php
						echo '<td><b>' . $report['DesVenc'][0]->Balancovenc . '</b></td>';
						for($i=1;$i<=31;$i++) {
							echo '<td class="text-left">' . $report['DesVenc'][0]->{'M'.$i} . '</td>';
						}
						echo '<td class="text-left">' . $report['TotalGeralvenc']->DesVenc . '</td>';
						?>
					</tr>
					<tr>
						<?php
						echo '<td><b>' . $report['DesPago'][0]->Balancopago . '</b></td>';
						for($i=1;$i<=31;$i++) {
							$bgcolor = ($report['DesPago'][0]->{'M'.$i} <= 0) ? 'bg-danger' : 'bg-danger';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['DesPago'][0]->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->DesPago <= 0) ? 'bg-danger' : 'bg-danger';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralpago']->DesPago . '</td>';
						?>
					</tr>
					<!--
					<tr>
						<?php
						echo '<td><b>' . $report['TotalVenc']->Balancovenc . '</b></td>';
						for($i=1;$i<=31;$i++) {
							$bgcolor = ($report['TotalVenc']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-success';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalVenc']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralvenc']->BalancoGeralvenc < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralvenc']->BalancoGeralvenc . '</td>';
						?>
					</tr>
					-->
					<tr>
						<?php
						echo '<td><b>' . $report['TotalPago']->Balancopago . '</b></td>';
						for($i=1;$i<=31;$i++) {
							$bgcolor = ($report['TotalPago']->{'M'.$i} < 0) ? 'bg-danger' : 'bg-info';
							echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalPago']->{'M'.$i} . '</td>';
						}
						$bgcolor = ($report['TotalGeralpago']->BalancoGeralpago < 0) ? 'bg-danger' : 'bg-info';
						echo '<td class="text-left ' . $bgcolor . '">' . $report['TotalGeralpago']->BalancoGeralpago . '</td>';
						?>
					</tr>

				</tbody>
				
			</table>

		</div>
		
	</div>

</div>
