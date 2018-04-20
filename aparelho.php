<?php
//Vivaldo Sidanez Papa Neto
//papaneto@hotmail.com
//19-04-2018

#revele minhas falhas
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

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

            $query = "SELECT descricao_aparelho, codigo_aparelho FROM aparelhos WHERE id_aparelho = $id;";

			$result = pg_query($conexao, $query);
			if (!$result) {
                http_response_code(500);
				$resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
				echo json_encode($resposta);
			}else{
                http_response_code(200);  
                $resposta['data'] = pg_fetch_assoc($result);
                echo json_encode($resposta);              
            }
        } else if (isset($_GET['f'])) {  
			$funcao = $_GET['f'];
			$funcao($conexao);
            
        } else {
            findAll($conexao);
        }
        break;
    case 'POST':
        if (isset($_GET['f'])) { 
            $funcao = $_GET['f'];
            $request = json_decode($_POST['request']);

            $funcao($conexao, $request);
        } elseif(count($_POST) > 0){
            $request = json_decode($_POST['request']);
            save($conexao, $request);                        
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
            echo json_encode(array("É necessario informar ID do aparelho."));            
        }
        
        break;
    case 'DELETE':
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            
        } else {
            http_response_code(400);
            echo json_encode(array("É necessario informar ID do aparelho."));            
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(array("Ta na disney."));
        break;
}

function findAll($conexao) {
    $query = "SELECT * FROM aparelhos;";

	$result = pg_query($conexao, $query);
	if (!$result) {
        http_response_code(500);
		$resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
		echo json_encode($resposta);
	}else{
        http_response_code(200);  
        $resposta['data'] = pg_fetch_all($result);
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