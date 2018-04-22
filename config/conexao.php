<?php
/* revele minhas falhas
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
*/

$host = 'localhost';
$port = '5432';
$user = 'postgres';
$pass = '';
$database = 'myusers';

$conexao = pg_connect("host=$host port=$port dbname=$database user=$user");

pg_set_client_encoding($conexao, "UNICODE");

if (!$conexao) {
	die('Connection error: deu ruim');
}