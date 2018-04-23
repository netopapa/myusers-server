<?php
//Vivaldo Sidanez Papa Neto
//papaneto@hotmail.com
//19-04-2018

#revele minhas falhas
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Content-Type: application/json; charset=utf8');

require_once("fpdf/fpdf.php");

$metodo = $_SERVER['REQUEST_METHOD'];
$resposta = array();

switch ($metodo) {
    case 'POST':
        $post = file_get_contents("php://input");
        $request = json_decode($post);
        
        if (isset($_GET["f"])) {
            $funcao = $_GET["f"];
            $funcao($request);
        } else {
            http_response_code(400);
            echo json_encode(array("Requisição incompleta."));
        }
        break;
    default:
        http_response_code(400);
        $resposta['msg'] = 'Tá na disney.';
        echo json_encode($resposta); 
    break;  
}

function pdfList($dados) {
    $pdf= new FPDF("P","pt","A4");
    $pdf->AddPage();
    
    if ($dados->tipo == 'aparelhos') {
        $nome_usuario = $dados->nome_usuario;
        
        $pdf->SetFont('arial','B',18);
        $pdf->Cell(0,5,"Relatorio",0,1,'C');
        $pdf->Cell(0,5,"","B",1,'C');
        $pdf->Ln(8);

        $pdf->SetFont('arial','B',12);
        $pdf->Cell(70,20,"Usuario:",0,0,'L');
        $pdf->setFont('arial','',12);
        $pdf->Cell(0,20,$nome_usuario,0,1,'L');
        $pdf->Ln(5);

        for ($i=0; $i < count($dados->data); $i++) {
            $descricao = $dados->data[$i]->descricao_aparelho;
            $codigo = $dados->data[$i]->codigo_aparelho;

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Descricao:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$descricao,0,1,'L');
            
            //Endereço
            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Codigo:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$codigo,0,1,'L');
            $pdf->Ln(2);
        }
        
    } elseif ($dados->tipo == 'usuarios') {

        $pdf->SetFont('arial','B',18);
        $pdf->Cell(0,5,"Relatorio",0,1,'C');
        $pdf->Cell(0,5,"","B",1,'C');
        $pdf->Ln(8);

        for ($i=0; $i < count($dados->data); $i++) {
            $nome = $dados->data[$i]->nome_usuario;
            $login = $dados->data[$i]->login;
            $email = $dados->data[$i]->email;
            $data_criacao = $dados->data[$i]->data_criacao;
            $codigo = $dados->data[$i]->cod_pessoa;

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Nome:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$nome,0,1,'L');
            $pdf->Ln(2);
            
            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Login:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$login,0,1,'L');
            $pdf->Ln(2);

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Email:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$email,0,1,'L');
            $pdf->Ln(2);

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Criado em:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$data_criacao,0,1,'L');
            $pdf->Ln(2);

            $pdf->SetFont('arial','B',12);
            $pdf->Cell(70,20,"Codigo:",0,0,'L');
            $pdf->setFont('arial','',12);
            $pdf->Cell(70,20,$codigo,0,1,'L');
            $pdf->Ln(5);
        }
    }
    
    try {
        $pdf->Output('relatorios/report.pdf','F');
    } finally {
        http_response_code(400);
    }

}

function txtList($dados) {
    $nome_usuario = $dados->nome_usuario;
    $fp = fopen("relatorios/report.txt", "w+");
 
    $escreve = fwrite($fp, "Usuário: $nome_usuario\r\n");

    for ($i=0; $i < count($dados->data); $i++) {
        $descricao = $dados->data[$i]->descricao_aparelho;
        $codigo = $dados->data[$i]->codigo_aparelho;

        $escreve = fwrite($fp, "--------------------------------------------\r\n");
        $escreve = fwrite($fp, "Descrição: $descricao\r\n");
        $escreve = fwrite($fp, "Código: $codigo \r\n");
    }
    
    // Fecha o arquivo
    fclose($fp);
}

function csvList($dados) {
    $nome_usuario = $dados->nome_usuario;
    $fp = fopen("relatorios/report.csv", "w+");
 
    $escreve = fwrite($fp, "Usuário: $nome_usuario,");

    for ($i=0; $i < count($dados->data); $i++) {
        $descricao = $dados->data[$i]->descricao_aparelho;
        $codigo = $dados->data[$i]->codigo_aparelho;

        $escreve = fwrite($fp, "Descrição: $descricao,");
        $escreve = fwrite($fp, "Código: $codigo,");
    }
    
    // Fecha o arquivo
    fclose($fp);
}

function txtListUser($dados) {
    $nome_usuario = $dados->nome_usuario;
    $fp = fopen("relatorios/report.txt", "w+");
 
    $escreve = fwrite($fp, "Usuário: $nome_usuario\r\n");

    for ($i=0; $i < count($dados->data); $i++) {
        $descricao = $dados->data[$i]->descricao_aparelho;
        $codigo = $dados->data[$i]->codigo_aparelho;

        $escreve = fwrite($fp, "--------------------------------------------\r\n");
        $escreve = fwrite($fp, "Descrição: $descricao\r\n");
        $escreve = fwrite($fp, "Código: $codigo \r\n");
    }
    
    // Fecha o arquivo
    fclose($fp);
}

function csvListUser($dados) {
    $nome_usuario = $dados->nome_usuario;
    $fp = fopen("relatorios/report.csv", "w+");
 
    $escreve = fwrite($fp, "Usuário: $nome_usuario,");

    for ($i=0; $i < count($dados->data); $i++) {
        $descricao = $dados->data[$i]->descricao_aparelho;
        $codigo = $dados->data[$i]->codigo_aparelho;

        $escreve = fwrite($fp, "Descrição: $descricao,");
        $escreve = fwrite($fp, "Código: $codigo,");
    }
    
    // Fecha o arquivo
    fclose($fp);
}