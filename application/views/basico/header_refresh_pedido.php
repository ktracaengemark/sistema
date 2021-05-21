<?php
#versão antiga do controle de sessão
//if (!isset($_SESSION['log'])) redirect('login/sair');
if (!isset($_SESSION['log']['idSis_Usuario'])) redirect('login/sair/FALSE');
$data['msg'] = '?m=6';
//if (!isset($_SESSION['log']['idSis_Usuario'])) redirect('login'.$data['msg']);
//if (!isset($_SESSION['log']['idSis_Usuario'])) redirect(base_url() . 'login' . $data['msg']);

#tempo de sessão = 2 horas
$tempo = 7200;
//teste de 30 segundos
//$tempo = 30;

#controle de sessão
/*
if ( (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempo)) || !isset($_SESSION['log'])) {
    redirect('login/sair/FALSE');
}
*/
if ((isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempo)) || !isset($_SESSION['log']['idSis_Usuario'])) {
    redirect('login/sair/FALSE');
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="refresh" content="30">-->
		<meta http-equiv="refresh" content="60;<?php echo base_url(); ?>pedidos2/pedidos">
		<meta http-equiv="refresh" content="<?php echo $tempo+1;?>;<?php echo base_url(); ?>login/sair/FALSE"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?php echo base_url() . '../'.$_SESSION['log']['Site'].'/' . $_SESSION['log']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['log']['Arquivo_Empresa'] . ''; ?>">

        <!-- <title>ROMATI - Agenda online de pacientes</title>-->
        <title><?php echo $_SESSION['log']['Nome2'] ?>/<?php echo $_SESSION['log']['NomeEmpresa2'] ?></title>        

        <!-- HUAP CSS Custom -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/huap.css">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-table.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/clockpicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/dashboard.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/chosen.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/fileinput.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/fullcalendar.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calendrical.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.min.css" rel="stylesheet" />


    </head>

    <body>
