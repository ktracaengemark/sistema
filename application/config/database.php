<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
/*
    'hostname' => '159.89.138.173',
	'username' => 'usuario',
	'password' => '20UtpJ15',
*/
    'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',

    #'database' => 'ci',
    'database' => 'app',	
	#'database' => 'app.testes',
	#'database' => 'app.testes3',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'latin1_swedish_ci',
	'swap_pre' => '',
	'autoinit' => TRUE,
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

/* End of file database.php */
/* Location: ./application/config/database.php */
