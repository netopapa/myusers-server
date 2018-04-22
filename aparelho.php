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
            echo json_encode(array("Requisição incompleta."));
        }
        break;
    default:
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            delete($conexao, $id);
        } else {
            http_response_code(400);
            $resposta['msg'] = 'É necessario informar ID do aparelho.';
            echo json_encode($resposta);          
        }
        break;  
}

#----------------------------------------------------------------------------------------------------

function findAll($conexao) {
    $query = "SELECT * FROM aparelhos;";

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

function save($conexao, $aparelho) {

    $query = "INSERT INTO aparelhos (descricao_aparelho,codigo_aparelho) VALUES ('$aparelho->descricao_aparelho', '$aparelho->codigo_aparelho');";

    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Aparelho salvo!';
        echo json_encode($resposta);              
    }
}

function update($conexao, $aparelho) {

    if (!$aparelho->id_aparelho) {
        http_response_code(400);
        $resposta['msg'] = 'É necessario informar ID do aparelho.';
        echo json_encode($resposta);
    } else {
        $query = "UPDATE aparelhos SET descricao_aparelho = '$aparelho->descricao_aparelho', codigo_aparelho = '$aparelho->codigo_aparelho' WHERE id_aparelho = $aparelho->id_aparelho;";
    
        $result = pg_query($conexao, $query);
    
        if (!$result) {
            http_response_code(500);
            $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
            echo json_encode($resposta);
        }else{
            http_response_code(200);  
            $resposta['msg'] = 'Aparelho alterado!';
            echo json_encode($resposta);      
        }
    }
    
}

function delete($conexao, $id) {
    $query = "DELETE FROM aparelhos WHERE id_aparelho = $id;";
    
    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Aparelho deletado!';
        echo json_encode($resposta);      
    }
}

function findOne($conexao, $id) {
    $query = "SELECT * FROM aparelhos WHERE id_aparelho = $id;";

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