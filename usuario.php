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

            findOne($conexao, $id);
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
        parse_str(file_get_contents("php://input"), $request);
        $request = json_decode($request['request']);
    
        update($conexao, $request);          
        break;
    case 'DELETE':
    
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            delete($conexao, $id);
        } else {
            http_response_code(400);
            $resposta['msg'] = 'É necessario informar ID do usuário.';
            echo json_encode($resposta);          
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(array("Ta na disney."));
        break;
}

#----------------------------------------------------------------------------------------------------

function findAll($conexao) {
    $query = "SELECT * FROM usuarios;";

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

function save($conexao, $usuario) {

    $query = "INSERT INTO usuarios (nome_usuario, login, email, senha, tempo_expiracao_senha, cod_autorizacao, cod_pessoa) VALUES ('$usuario->nome_usuario', '$usuario->login', '$usuario->email', '$usuario->senha', 1200, '$usuario->cod_autorizacao', $usuario->cod_pessoa);";

    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Usuário salvo!';
        echo json_encode($resposta);              
    }
}

function update($conexao, $usuario) {

    if (!$usuario->id_usuario) {
        http_response_code(400);
        $resposta['msg'] = 'É necessario informar ID do usuário.';
        echo json_encode($resposta);
    } else {
        $query = "UPDATE usuarios SET nome_usuario = '$usuario->nome_usuario', login = '$usuario->login', email = '$usuario->email', senha = '$usuario->senha', cod_autorizacao = '$usuario->cod_autorizacao', cod_pessoa = '$usuario->cod_pessoa' WHERE id_usuario = $usuario->id_usuario;";
    
        $result = pg_query($conexao, $query);
    
        if (!$result) {
            http_response_code(500);
            $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
            echo json_encode($resposta);
        }else{
            http_response_code(200);  
            $resposta['msg'] = 'Usuário alterado!';
            echo json_encode($resposta);      
        }
    }
    
}

function delete($conexao, $id) {
    $query = "DELETE FROM usuarios WHERE id_usuario = $id;";
    
    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        http_response_code(200);  
        $resposta['msg'] = 'Usuário deletado!';
        echo json_encode($resposta);      
    }
}

function findOne($conexao, $id) {
    $query = "SELECT * FROM usuarios WHERE id_usuario = $id;";

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