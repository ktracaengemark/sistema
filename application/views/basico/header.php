<?php 
#versão antiga do controle de sessão
#if (!isset($_SESSION['log'])) redirect('login/sair'); 

#tempo de sessão = 5 horas
$tempo = 18000;
#$tempo = 5;

#controle de sessão
if ( (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tempo)) || !isset($_SESSION['log'])) {
    redirect('login/sair/FALSE');    
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="refresh" content="<?php echo $tempo+1; ?>;<?php echo base_url(); ?>login/sair/FALSE"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <!-- <title>ROMATI - Agenda online de pacientes</title>-->
        <title>ROMATI - Agenda Pet Online</title>        

        <!-- HUAP CSS Custom -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/huap.css">        

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">

        <!-- Custom styles for this template -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.ui.css">
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
