<!DOCTYPE html>
<html>
<head>
	<title>testes</title>
	<meta charset="UTF-8">
</head>
<body>
	<h1>TESTES TESTES TESTES TESTES TESTES TESTES TESTES TESTES TESTES</h1>
	<input type="file" id="file" name="file">
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

	var dados = {};
	dados.descricao_aparelho = 'cebolinha';
	dados.codigo_aparelho = '11';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'aparelho.php',
		type: 'POST',
		dataType: 'json',
		data: {request: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});

	/*
	var dados = {};
	dados.idProf = 11;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=listarMensagens',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});

	var dados = {};
	dados.competencia = 'me mata por favor';
	dados.idProf = 11;
	dados.ramo = 'Design';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=getProfissionalPorRamo',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/*var dados = {};
	dados.idHistorico = 2;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=removeHistoricoProfissional',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/*var dados = {};
	dados.idHistorico = 1;

	dados.empresa = 'SIDIA';
	dados.cargo = 'Analista de sistemas PLENO';
	dados.descritivo = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis nesciunt odit illo quidem, minima, atque minus, debitis doloremque cupiditate animi.';
	dados.dt_inicio = '2017-01-02';
	dados.dt_fim = '';
	dados.atual = 1;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=attHistoricoProfissional',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/*var dados = {};
	dados.idProf = 11;

	dados.empresa = 'KONEC';
	dados.cargo = 'Analista de sistemas';
	dados.descritivo = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis nesciunt odit illo quidem, minima, atque minus, debitis doloremque cupiditate animi dolorem blanditiis unde dicta tempora sed ab ut similique ipsum.';
	dados.dt_inicio = '2017-01-02';
	dados.dt_fim = '';
	dados.atual = 1;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=addHistoricoProfissional',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/*//busca competencias de profissional
	var dados = {};
	dados.idProf = 11;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=getProfissionalCompetencias',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/*//filtro de vagas
	var dados = [];
	var filtro = {};

	// filtro.tipo = 'cidade';
	// filtro.filtro = 'Manaus';

	// dados.push(filtro);

	filtro = {};
	filtro.tipo = 'ramo';
	filtro.filtro = 'Design';

	dados.push(filtro);
	// console.log(dados);

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=filtraVaga',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});*/

	/* #nova senha
	var dados = {};

	dados.senha = 'nova senha 123';
	dados.cpf_cnpj = '029.066.752-61';

	dados = JSON.stringify(dados);
	console.log(dados);

	$.ajax({
		url: 'server.php?f=attSenha',
		type: 'PUT',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #atualizar vaga
	var dados = {};
	//pessoais
	dados.cargo = 'Secretária senior';
	dados.dt_inicio = '2017-10-20';
	dados.dt_fim = '2017-11-20';
	dados.salario = 1200;
	dados.descritivo = 'Corajoso deve estar familiarizado com WORD 2017, EXCEL 2017 e monitoramento de atividades.';
	dados.id = 1;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=attVaga',
		type: 'PUT',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #cadastro de vaga
	var dados = {};
	//pessoais
	dados.cargo = 'Secretária';
	dados.dt_inicio = '2017-10-15';
	dados.dt_fim = '';
	dados.salario = 1000;
	dados.descritivo = 'Candidato deve estar familiarizado com WORD 2017, EXCEL 2017 e monitoramento de atividades.';
	dados.empregador_id = 2;
	dados.endereco_id = 2;

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=addVaga',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #alterar dados pessoais profissional
	var dados = {};
	//pessoais
	dados.nome = 'nome empresa';
	dados.email = 'email teste';
	dados.email_alt = 'email alternativo';
	dados.cpf_cnpj = '029.066.752-61';
	dados.area = 'software';
	dados.nacionalidade = 'Portugues';
	dados.genero = 'Masculino';
	dados.escolaridade_id = 3;
	dados.foto = '02906675261.png';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=attProfissional',
		type: 'PUT',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #alterar dados de endereço
	var dados = {};
	//endereço
	dados.pais = 'America';
	dados.estado = 'teste';
	dados.cidade = 'teste';
	dados.bairro = 'teste Dez De Novembro';
	dados.rua = 'teste rio negro';
	dados.cep = 'teste-560';
	dados.numero = 'teste';

	dados.endereco_id = 2;

	dados = JSON.stringify(dados);
	console.log(dados);

	$.ajax({
		url: 'server.php?f=attEndereco',
		type: 'PUT',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #alterar dados pessoais empregador
	var dados = {};
	//pessoais
	dados.nome = 'nome empresa';
	dados.email = 'email teste';
	dados.email_alt = 'email alternativo';
	dados.cpf_cnpj = '78.425.986/0036-15';
	dados.ramo = 'software';
	dados.categoria = 'industria';
	dados.foto = '78425986003615.png';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=attEmpregador',
		type: 'PUT',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* #login
	dados = {};
	dados.login = '02906675261';
	dados.pass = '123';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=login',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(JSON.stringify(data));
	})
	.fail(function(data) {
		console.log(JSON.stringify(data));
	});
	*/

	/*
	#cadastro de empregador
	var dados = {};
	//pessoais
	dados.nome = 'nome empresa';
	dados.email = 'email teste';
	dados.senha = '!@#$';
	dados.cpf_cnpj = '78.425.986/0036-15';
	dados.tipoPessoa = 'j';
	dados.ramo = 'tecnologia';
	dados.categoria = 'startup';
	dados.foto = '78425986003615.png';

	//endereço
	dados.pais = 'Brasil';
	dados.estado = 'Amazonas';
	dados.cidade = 'Manaus';
	dados.bairro = 'Parque Dez De Novembro';
	dados.rua = 'alameda rio negro';
	dados.cep = '69050-560';
	dados.numero = '23';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=addEmpregador',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/

	/* 
	#upload de imagem
	$("#file").change(function(event) {
		var file = $("#file").prop('files')[0];

		var json = {};
		//pessoais
		json.cpf_cnpj = '029.066.752-61';

		json = JSON.stringify(json);

		var dados = new FormData();

		dados.append('file', file);
		dados.append('dados', json);

		$.ajax({
			url: 'server.php',
			type: 'POST',
			data: dados,
	        processData: false,
	        contentType: false,
		})
		.done(function(data) {
			console.log(data);
		})
		.fail(function(data) {
			console.log(data);
		});
	});
	*/

	/*
	#cadastro de profissional - campos de texto
	var dados = {};
	//pessoais
	dados.nome = 'nome teste';
	dados.email = 'email teste';
	dados.senha = '!@#$';
	dados.cpf_cnpj = '029.066.752-61';
	dados.dt_nasc = '2017-09-01';
	dados.area = 'tecnologia';
	dados.foto = '02906675261.png';

	//endereço
	dados.pais = 'Brasil';
	dados.estado = 'Amazonas';
	dados.cidade = 'Manaus';
	dados.bairro = 'Parque Dez De Novembro';
	dados.rua = 'alameda rio negro';
	dados.cep = '69050-560';
	dados.numero = '23';

	dados = JSON.stringify(dados);

	$.ajax({
		url: 'server.php?f=addProfissional',
		type: 'POST',
		dataType: 'json',
		data: {dados: dados},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(data) {
		console.log(data);
	});
	*/
	
</script>
</html>