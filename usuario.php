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

    $query = "SELECT * FROM usuarios;";

	$result = pg_query($conexao, $query);
	if (!$result) {
        http_response_code(500);
		$resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
		echo json_encode($resposta);
	}else{
        $resposta = pg_fetch_all($result);
        
        for ($i=0; $i < count($resposta); $i++) {
            $id_usuario = $resposta[$i]['id_usuario'];
            $query = "SELECT C.* FROM usuarios A RIGHT JOIN usuarios_aparelhos B ON A.id_usuario = B.id_usuario RIGHT JOIN aparelhos C ON B.id_aparelho = C.id_aparelho WHERE A.id_usuario = $id_usuario;";
            
            $result = pg_query($conexao, $query);
            
            $resposta[$i]['aparelhos'] = pg_fetch_all($result);
        }

        for ($i=0; $i < count($resposta); $i++) {
            $id_usuario = $resposta[$i]['id_usuario'];
            $query = "SELECT C.* FROM usuarios A RIGHT JOIN usuarios_perfil B ON A.id_usuario = B.id_usuario RIGHT JOIN perfil C ON B.id_perfil = C.id_perfil WHERE A.id_usuario = $id_usuario;";
            
            $result = pg_query($conexao, $query);
            
            $resposta[$i]['perfis'] = pg_fetch_all($result);
        }
        
        http_response_code(200);  
        echo json_encode($resposta);              
    }
}

function save($conexao, $usuario) {

    $query = "INSERT INTO usuarios (nome_usuario, login, email, senha, tempo_expiracao_senha, cod_autorizacao, cod_pessoa) VALUES ('$usuario->nome_usuario', '$usuario->login', '$usuario->email', '$usuario->senha', 1200, 't', $usuario->cod_pessoa) RETURNING id_usuario;";

    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{

        $result = pg_fetch_all($result);
        $id_usuario = $result[0]['id_usuario'];

        $result = true;
        $multiple = '';

        for ($i=0; $i < count($usuario->aparelhos); $i++) {
            $id_aparelho = $usuario->aparelhos[$i]->id_aparelho;
            $multiple .= "($id_usuario, $id_aparelho)";
            
            if ($i < count($usuario->aparelhos) - 1) {
                $multiple .= ', ';
            }
        }

        if ($multiple != '') {
            $query = "INSERT INTO usuarios_aparelhos (id_usuario, id_aparelho) VALUES $multiple;";
            $result = pg_query($conexao, $query);
        }

        $result = true;
        $multiple = '';

        for ($i=0; $i < count($usuario->perfis); $i++) {
            $id_perfil = $usuario->perfis[$i]->id_perfil;
            $multiple .= "($id_usuario, $id_perfil)";
            
            if ($i < count($usuario->perfis) - 1) {
                $multiple .= ', ';
            }
        }

        if ($multiple != '') {
            $query = "INSERT INTO usuarios_perfil (id_usuario, id_perfil) VALUES $multiple;";
            $result = pg_query($conexao, $query);
        }

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

            $query = "DELETE FROM usuarios_aparelhos WHERE id_usuario = $usuario->id_usuario";
            $result = pg_query($conexao, $query);

            $result = true;
            $multiple = '';

            for ($i=0; $i < count($usuario->aparelhos); $i++) {
                $id_aparelho = $usuario->aparelhos[$i]->id_aparelho;
                $multiple .= "($usuario->id_usuario, $id_aparelho)";
                
                if ($i < count($usuario->aparelhos) - 1) {
                    $multiple .= ', ';
                }
            }
    
            if ($multiple != '') {
                $query = "INSERT INTO usuarios_aparelhos (id_usuario, id_aparelho) VALUES $multiple;";
                $result = pg_query($conexao, $query);
            }

            $result = true;
            $multiple = '';

            for ($i=0; $i < count($usuario->perfis); $i++) {
                $id_perfil = $usuario->perfis[$i]->id_perfil;
                $multiple .= "($usuario->id_usuario, $id_perfil)";
                
                if ($i < count($usuario->perfis) - 1) {
                    $multiple .= ', ';
                }
            }

            if ($multiple != '') {
                $query = "INSERT INTO usuarios_perfil (id_usuario, id_perfil) VALUES $multiple;";
                $result = pg_query($conexao, $query);
            }
    
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
    
}

function delete($conexao, $id) {
    $query = "DELETE FROM usuarios_aparelhos WHERE id_usuario = $id;";
    
    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
        $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
        echo json_encode($resposta);
    }else{
        $query = "DELETE FROM usuarios_perfil WHERE id_usuario = $id;";
    
        $result = pg_query($conexao, $query);
        
        if (!$result) {
            http_response_code(500);
            $resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
            echo json_encode($resposta);
        }else{
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
        $resposta = pg_fetch_assoc($result);

        $id_usuario = $resposta['id_usuario'];
        $query = "SELECT C.* FROM usuarios A RIGHT JOIN usuarios_aparelhos B ON A.id_usuario = B.id_usuario RIGHT JOIN aparelhos C ON B.id_aparelho = C.id_aparelho WHERE A.id_usuario = $id_usuario;";
        
        $result = pg_query($conexao, $query);
        
        $resposta['aparelhos'] = pg_fetch_all($result);

        http_response_code(200);  
        echo json_encode($resposta);              
    }
}

function findByPerfil($conexao, $perfil) {
    $query = "SELECT A.* FROM usuarios A INNER JOIN usuarios_perfil B ON A.id_usuario = B.id_usuario INNER JOIN perfil C ON B.id_perfil = C.id_perfil WHERE C.id_perfil = $perfil->id_perfil;";
        
    $result = pg_query($conexao, $query);

    if (!$result) {
        http_response_code(500);
		$resposta['msg'] = 'Desculpe, houve uma falha interna. Tente novamente.';
		echo json_encode($resposta);
	}else{

        $resposta = pg_fetch_all($result);
        
        for ($i=0; $i < count($resposta); $i++) {
            $id_usuario = $resposta[$i]['id_usuario'];
            $query = "SELECT C.* FROM usuarios A RIGHT JOIN usuarios_aparelhos B ON A.id_usuario = B.id_usuario RIGHT JOIN aparelhos C ON B.id_aparelho = C.id_aparelho WHERE A.id_usuario = $id_usuario;";
            
            $result = pg_query($conexao, $query);
            
            $resposta[$i]['aparelhos'] = pg_fetch_all($result);
        }

        for ($i=0; $i < count($resposta); $i++) {
            $id_usuario = $resposta[$i]['id_usuario'];
            $query = "SELECT C.* FROM usuarios A RIGHT JOIN usuarios_perfil B ON A.id_usuario = B.id_usuario RIGHT JOIN perfil C ON B.id_perfil = C.id_perfil WHERE A.id_usuario = $id_usuario;";
            
            $result = pg_query($conexao, $query);
            
            $resposta[$i]['perfis'] = pg_fetch_all($result);
        }

        http_response_code(200);  
        echo json_encode($resposta);              
    }
}