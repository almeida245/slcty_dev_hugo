<?php 

$conn = new mysqli("localhost", "root", "", "teste_selecty");
if ($conn->connect_error) {
	die("Sem conexão com o banco de dados.");
} 
$res = array('error' => false);

$acao = '';

if (isset($_POST['acao'])) {
	$acao = $_POST['acao'];
}

if ($acao == 'incluir') {
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$experiencia = $_POST['experiencia'];
	$formacao = $_POST['formacao'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$result = $conn->query("INSERT INTO candidato (nome, email, telefone, experiencia, formacao, login, senha) VALUES ('$nome', '$email', '$telefone', '$experiencia', '$formacao', '$login', '$senha') ");
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		exit;
	}
}

if ($acao == 'alterar') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$experiencia = $_POST['experiencia'];
	$formacao = $_POST['formacao'];
	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$result = $conn->query("UPDATE candidato SET nome = '$nome', email = '$email', telefone = '$telefone', experiencia = '$experiencia', formacao = '$formacao', login = '$login', senha = '$senha' WHERE id = '$id'");
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		exit;
	}
}

if ($acao == 'deletar') {
	$id = $_POST['id'];

	$result = $conn->query("DELETE FROM candidato WHERE id = '$id'");
	if ($result) {
		$conn -> close();
		echo 'ok';
		exit;
	} else{
		$conn -> close();
		echo 'err';
		exit;
	}
}

?>
