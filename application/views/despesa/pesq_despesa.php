<?php if (isset($msg)) echo $msg; ?>

<div class="row">

    <div class="col-md-1"></div>
    <div class="col-md-10">

        <?php echo validation_errors(); ?>

        <div class="panel panel-primary">

            <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
            <div class="panel-body">

                <?php echo form_open($form_open_path, 'role="form"'); ?>

				<div class="form-group">
					<div class="row">
                        <div class="col-md-3">
                            <label for="Despesa">Nome do Despesa: *</label><br>
                            <input type="text" class="form-control" maxlength="200"
                                   autofocus name="Despesa" value="<?php echo $despesa['Despesa'] ?>">
                        </div>
						<div class="col-md-3">
							<label for="TipoDespesa">Tipo Despesa</label>
							<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>tipodespesa/cadastrar/tipodespesa" role="button">
								<span class="glyphicon glyphicon-plus"></span> <b>Forma Pag</b>
							</a>-->
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="TipoDespesa" name="TipoDespesa">
								<option value="">-- Sel. Tipo Despesa --</option>
								<?php
								foreach ($select['TipoDespesa'] as $key => $row) {
									if ($despesa['TipoDespesa'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>

						<div class="col-md-3">
							<label for="ValorTotalDesp">Valor Total da Desp.:</label><br>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">R$</span>
								<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
									    name="ValorTotalDesp" value="<?php echo $despesa['ValorTotalDesp'] ?>">
							</div>
						</div>
						<div class="col-md-3">
                            <label for="DataDesp">Data da Desp..</label>
                            <div class="input-group <?php echo $datepicker; ?>">
                                <input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
                                    name="DataDesp" value="<?php echo $despesa['DataDesp']; ?>">
                                <span class="input-group-addon" disabled>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-3">
							<label for="FormaPag">Forma Pag</label>
							<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>formapag/cadastrar/formapag" role="button">
								<span class="glyphicon glyphicon-plus"></span> <b>Forma Pag</b>
							</a>-->
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="FormaPag" name="FormaPag">
								<option value="">-- Sel. Forma --</option>
								<?php
								foreach ($select['FormaPag'] as $key => $row) {
									if ($despesa['FormaPag'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>
						
						<div class="col-md-4">
							<label for="Empresa">Empresa</label>
							<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>empresa/cadastrar/empresa" role="button">
								<span class="glyphicon glyphicon-plus"></span> <b>Empresa</b>
							</a>
							<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
									id="Empresa" name="Empresa">
								<option value="">-- Sel. Empresa --</option>
								<?php
								foreach ($select['Empresa'] as $key => $row) {
									if ($despesa['Empresa'] == $key) {
										echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
									} else {
										echo '<option value="' . $key . '">' . $row . '</option>';
									}
								}
								?>
							</select>
						</div>


						<!--<div class="col-md-2">
                            <label for="Unidade">Unidade de Medida:</label><br>
                            <input type="text" class="form-control" maxlength="20"
                                   autofocus name="Unidade" value="<?php echo $query['Unidade'] ?>">
                        </div>-->

                    </div>
				</div>
				<hr>

				<div class="form-group">
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#FormaPagamento" aria-expanded="false" aria-controls="FormaPagamento">
								<span class="glyphicon glyphicon-menu-down"></span> Parcelas / Faturado
							</button>
						</div>
					</div>
				</div>

					<hr>

				<div <?php echo $collapse; ?> id="FormaPagamento">

					<div class="form-group">
						<div class="row">

							<div class="col-md-1">
								<label for="QtdParcDesp">Qt.Parc.</label><br>
									<input type="text" class="form-control" maxlength="3"
										   name="QtdParcDesp" value="<?php echo $despesa['QtdParcDesp'] ?>">
							</div>

							<div class="col-md-3">
								<label for="ValorDesp">Valor das Parcelas: *</label><br>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">R$</span>
									<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
											name="ValorDesp" value="<?php echo $despesa['ValorDesp'] ?>">
								</div>
							</div>

							<div class="col-md-3">
								<label for="DataVencDesp">Data 1�Venc</label>
								<div class="input-group <?php echo $datepicker; ?>">
									<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
										name="DataVencDesp" value="<?php echo $despesa['DataVencDesp']; ?>">
									<span class="input-group-addon" disabled>
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
							<br>
							<div class="form-group">
								<div class="col-md-2 text-right">
									<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas">
										<span class="glyphicon glyphicon-menu-down"></span> Gerar Parc.
									</button>
								</div>
							</div>
						</div>
					</div>

                    <hr>
					<!--"App_ParcelasDesp"-->
					<div <?php echo $collapse; ?> id="Parcelas">
						<div class="form-group">
							<div class="row">
								<div class="col-md-1">
									<label for="ParcDesp">Parc.</label><br>
										<input type="text" class="form-control" maxlength="6"
												name="ParcDesp" value="<?php echo $parcelasdesp['ParcDesp'] ?>">
								</div>
								<div class="col-md-3">
									<label for="ValorParcDesp">Valor Parcela</label><br>
									<div class="input-group" id="txtHint">
										<span class="input-group-addon" id="basic-addon1">R$</span>
										<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
												name="ValorParcDesp" value="<?php echo $parcelasdesp['ValorParcDesp'] ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label for="DataVencParcDesp">Venc.da Parc.</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											name="DataVencParcDesp" value="<?php echo $parcelasdesp['DataVencParcDesp']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-3">
									<label for="ValorPagoDesp">Valor Pago</label><br>
									<div class="input-group" id="txtHint">
										<span class="input-group-addon" id="basic-addon1">R$</span>
										<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00"
												name="ValorPagoDesp" value="<?php echo $parcelasdesp['ValorPagoDesp'] ?>">
									</div>
								</div>
								<div class="col-md-2">
									<label for="DataPagoDesp">Data Pagam.</label>
									<div class="input-group <?php echo $datepicker; ?>">
										<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
											name="DataPagoDesp" value="<?php echo $parcelasdesp['DataPagoDesp']; ?>">
										<span class="input-group-addon" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-md-1">
								<label for="QuitDesp">Qt?</label><br>
									<input type="text" class="form-control" maxlength="1"
									name="QuitDesp" value="<?php echo $parcelasdesp['QuitDesp'] ?>">
							</div>

							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<div class="row">							
							<div class="col-md-6">
								<label for="ObsDesp">OBS:</label>
								<textarea class="form-control" id="ObsDesp" <?php echo $readonly; ?>
										  name="ObsDesp"><?php echo $despesa['ObsDesp']; ?></textarea>
							</div>
						</div>
					</div>
				</div>
					<hr>

                    <div class="row">
                        <div class="col-md-2">
                            <?php echo $button ?>
                        </div>

                        <input type="hidden" name="idApp_Despesa" value="<?php echo $despesa['idApp_Despesa']; ?>">
						<input type="hidden" name="idApp_ParcelasDesp" value="<?php echo $parcelasdesp['idApp_ParcelasDesp']; ?>">

                    </div>
                </form>

                <br>

                <?php if (isset($list)) echo $list; ?>

            </div>

        </div>

    </div>
    <div class="col-md-2"></div>

</div>
