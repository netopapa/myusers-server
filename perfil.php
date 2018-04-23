<?php
//Vivaldo Sidanez Papa Neto
//papaneto@hotmail.com
//19-04-2018

#revele minhas falhas
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
header('Content-Type: application/json; charset=utf8');

require 'config/conexao.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$resposta = array();

switch ($metodo) {
    case 'GET':
        #busca usuario especifico
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            findOne($conexao, $id);
        } else if (isset($_GET['f'])) {  
            $funcao = $_GET['f'];
            $funcao($conexao);
            
        } else {
            findAll($conexao);
        }
        break;
    case 'POST':
        $post = file_get_contents("php://input");
        $request = json_decode($post);

        if (isset($_GET['f'])) { 
            $funcao = $_GET['f'];

            $funcao($conexao, $request);
        } elseif(count($request) > 0){
            save($conexao, $request);                        
        }else{
            http_response_code(400);
            $resposta['msg'] = 'Requisição incompleta.';
            echo json_encode($resposta);
        }
        break;
    default:
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            delete($conexao, $id);
        } else {
            http_response_code(400);
            $resposta['msg'] = 'É necessario informar ID do Usuário.';
            echo json_encode($resposta);          
        }
    break;  
}

#----------------------------------------------------------------------------------------------------

function findAll($conexao) {

    $query = "SELECT * FROM perfil;";

	$result = pg_query($conexao, $query);
    
    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta = pg_fetch_all($result);
        echo json_encode($resposta);       
    }
}

function save($conexao, $perfil) {

    $query = "INSERT INTO perfil (nome_perfil) VALUES ('$perfil->nome_perfil');";

    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Perfil salvo!';
        echo json_encode($resposta);       
    }
}

function update($conexao, $perfil) {

    if (!$perfil->id_perfil) {
        http_response_code(400);
        $resposta['msg'] = 'É necessario informar ID do perfil.';
        echo json_encode($resposta);
    } else {
        $query = "UPDATE perfil SET nome_perfil = '$perfil->nome_perfil' WHERE id_perfil = $perfil->id_perfil;";
    
        $result = pg_query($conexao, $query);
    
        if (!$result) {
            http_response_code(500);
            $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
            echo json_encode($resposta);
        }else{
            http_response_code(200);  
            $resposta['msg'] = 'Perfil alterado!';
            echo json_encode($resposta);      
        }   
    }
}

function delete($conexao, $id) {
    $query = "DELETE FROM perfil WHERE id_perfil = $id;";
    
    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, ação negada. Verifique se este registro está associado à um usuário.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Perfil deletado!';
        echo json_encode($resposta);      
    }
}

function findOne($conexao, $id) {
    $query = "SELECT * FROM perfil WHERE id_perfil = $id;";

    $result = pg_query($conexao, $query);
    
	if (!$result) {
        http_response_code(500);
		$resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
		echo json_encode($resposta);
	}else{
        http_response_code(200);  
        $resposta = pg_fetch_assoc($result);
        echo json_encode($resposta);              
    }
}