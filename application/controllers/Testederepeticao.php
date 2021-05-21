			<?php
			
				$data['repeticao']['1']['Dia_Semana'] = "SEGUNDA";
                $data['repeticao']['2']['Dia_Semana'] = "TERCA";
                $data['repeticao']['3']['Dia_Semana'] = "QUARTA";
                $data['repeticao']['4']['Dia_Semana'] = "QUINTA";
                $data['repeticao']['5']['Dia_Semana'] = "SEXTA";
                $data['repeticao']['6']['Dia_Semana'] = "SABADO";
                $data['repeticao']['7']['Dia_Semana'] = "DOMINGO";
			
				for($j=1; $j<=7; $j++) {
					
					$data['repeticao'][$j]['Repeticao'] = $data['idApp_Consulta'];
					$data['repeticao'][$j]['idApp_Agenda'] = $data['query']['idApp_Agenda'];
					$data['repeticao'][$j]['idApp_Cliente'] = $data['query']['idApp_Cliente'];
					$data['repeticao'][$j]['Evento'] = $data['query']['Evento'];
					$data['repeticao'][$j]['Obs'] = $data['query']['Obs'];
					$data['repeticao'][$j]['idApp_Profissional'] = $data['query']['idApp_Profissional'];
					$data['repeticao'][$j]['idTab_Status'] = $data['query']['idTab_Status'];
					$data['repeticao'][$j]['Tipo'] = 1;
					$data['repeticao'][$j]['DataInicio'] = date('Y-m-d', strtotime('+ ' . ($n*$j) . ' day',strtotime($datainicio))) . ' ' . $horainicio;
					$data['repeticao'][$j]['DataFim'] = date('Y-m-d', strtotime('+ ' . ($n*$j) . ' day',strtotime($datafim))) . ' ' . $horafim;
					$data['repeticao'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['repeticao'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['repeticao'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					
					$data['repeticao'][$j] = array(
						'Repeticao' 			=> $data['idApp_Consulta'],
						'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
						'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
						'Evento' 				=> $data['query']['Evento'],
						'Obs' 					=> $data['query']['Obs'],
						'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
						'idTab_Status' 			=> $data['query']['idTab_Status'],
						'Tipo' 					=> 1,
						'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($n*$j) . ' day',strtotime($datainicio))) . ' ' . $horainicio,
						'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($n*$j) . ' day',strtotime($datafim))) . ' ' . $horafim,
						'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
						'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
						'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']					
					/*
						'idSis_Empresa' => $data['idSis_Empresa'],
						'id_Dia' => $j,
						'Dia_Semana' => $data['repeticao'][$j]['Dia_Semana'],
						'Aberto' => "S",
						'Hora_Abre' => "00:00:00",
						'Hora_Fecha' => "23:59:59"
					*/
					);
					$data['campos'] = array_keys($data['repeticao'][$j]);
					$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
				}
				
				
				
				
				$data['atendimento']['1']['Dia_Semana'] = "SEGUNDA";
                $data['atendimento']['2']['Dia_Semana'] = "TERCA";
                $data['atendimento']['3']['Dia_Semana'] = "QUARTA";
                $data['atendimento']['4']['Dia_Semana'] = "QUINTA";
                $data['atendimento']['5']['Dia_Semana'] = "SEXTA";
                $data['atendimento']['6']['Dia_Semana'] = "SABADO";
                $data['atendimento']['7']['Dia_Semana'] = "DOMINGO";
				
				for($j=1; $j<=7; $j++) {
					$data['atendimento'][$j] = array(
						'idSis_Empresa' => $data['idSis_Empresa'],
						'id_Dia' => $j,
						'Dia_Semana' => $data['atendimento'][$j]['Dia_Semana'],
						'Aberto' => "S",
						'Hora_Abre' => "00:00:00",
						'Hora_Fecha' => "23:59:59"
					);
					$data['campos'] = array_keys($data['atendimento'][$j]);
					$data['idApp_Atendimento'] = $this->Loginempresa_model->set_atendimento($data['atendimento'][$j]);
				}				