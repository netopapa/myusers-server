<?php
//Vivaldo Sidanez Papa Neto
//papaneto@hotmail.com
//19-04-2018

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf8');

require 'config/conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$resposta = array();

switch ($metodo) {
    case 'GET':
        #busca usuario especifico
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        #busca usuarios
        } else {
            
        }
        break;
    case 'POST':
        if(count($_POST) > 0){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            
        }else{
            http_response_code(400);
            echo json_encode(array("Requisição incompleta."));
        }
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $post_vars);
        
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            
        } else {
            http_response_code(400);
            echo json_encode(array("É necessario informar ID do usuario."));            
        }
        
        break;
    case 'DELETE':
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            
        } else {
            http_response_code(400);
            echo json_encode(array("É necessario informar ID do usuario."));            
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(array("Ta na disney."));
        break;
}