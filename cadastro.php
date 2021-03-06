<?php
$acao = 'incluir';
$candidato = array();
if($_GET['acao']){
	$acao = $_GET['acao'];
}
$id = '';
if(isset($_GET['id']) && $_GET['id'] > 0){
	$id = $_GET['id'];

	include 'DB.php';
	$db = new DB();
	$candidato = $db->getCandidato($id);
}

$nome = isset($candidato['nome']) ? $candidato['nome'] : '';
$email = isset($candidato['email']) ? $candidato['email'] : '';
$telefone = isset($candidato['telefone']) ? $candidato['telefone'] : '';
$experiencia = isset($candidato['experiencia']) ? $candidato['experiencia'] : '';
$formacao = isset($candidato['formacao']) ? $candidato['formacao'] : '';
$login = isset($candidato['login']) ? $candidato['login'] : '';
$senha = isset($candidato['senha']) ? $candidato['senha'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Teste Selecty</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body>

	<div id="principal">
		<form id="formulario" action="api.php" method="post">
			<input type="hidden" name="id" id="id" value="<?=$id?>">
			<h1>Cadastro de Candidato:</h1>

			<div class="tab">Dados Pessoais:
			  <p><input type="text" placeholder="Nome" name="nome" id="nome" value="<?=$nome?>"></p>
			  <p><input type="email" placeholder="Email" name="email" id="email" value="<?=$email?>"></p>
			  <p><input type="text" placeholder="Telefone" name="telefone" id="telefone" value="<?=$telefone?>"></p>
			</div>

			<div class="tab">Dados Profissionais:
			  <p><textarea placeholder="Experi&ecirc;ncia" name="experiencia" id="experiencia" cols="100"><?=$experiencia?></textarea></p>
			  <p><textarea placeholder="Forma&ccedil;&atilde;o" name="formacao" id="formacao" cols="100"><?=$formacao?></textarea></p>
			</div>

			<div class="tab">Dados de Acesso:
			  <p><input type="text" placeholder="Usu&aacute;rio" name="login" id="login" value="<?=$login?>"></p>
			  <p><input type="password" placeholder="Senha" name="senha" id="senha" ></p>
			  <p><input type="password" placeholder="Confirme sua Senha" name="confirme_senha" id="confirme_senha"></p>
			</div>

			<div style="overflow:auto;">
			  <div style="float:right;">
			    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
			    <button type="button" id="nextBtn" onclick="nextPrev(1)">Próximo</button>
			  </div>
			</div>

			<div style="text-align:center;margin-top:40px;">
			  <span class="step"></span>
			  <span class="step"></span>
			  <span class="step"></span>
			</div>
		</form>		
	</div>	

	<script>
		var currentTab = 0;
		showTab(currentTab);

		function showTab(n) {
			var x = document.getElementsByClassName("tab");
			x[n].style.display = "block";
			  
			if (n == 0) {
			    document.getElementById("prevBtn").style.display = "none";
			} 
			else {
			    document.getElementById("prevBtn").style.display = "inline";
			}
			
			if (n == (x.length - 1)) {
			    document.getElementById("nextBtn").innerHTML = "Salvar";			    
			} 
			else {
			    document.getElementById("nextBtn").innerHTML = "Próximo";
			}
			  
			fixStepIndicator(n)
		}

		function nextPrev(n) {
		    var x = document.getElementsByClassName("tab");
		    // Exit the function if any field in the current tab is invalid:
		    if (n == 1 && !validateForm()) return false;
		    // Hide the current tab:
		    x[currentTab].style.display = "none";
		    
		    currentTab = currentTab + n;
		  
		    if (currentTab >= x.length) {
			    salvarCandidato('<?=$acao?>', '<?=$id?>');
		    	return false;
		  	}
			
			showTab(currentTab);
		}

		function validateForm() {
			var valid = true;

			if(currentTab == 0){
				if(document.getElementById('nome').value == ''){
					document.getElementById('nome').className = 'invalid';
					valid = false;
				}

				if(document.getElementById('email').value == '' && document.getElementById('telefone').value == ''){
					document.getElementById('email').className = 'invalid';
					document.getElementById('telefone').className = 'invalid';
					valid = false;
				}
			}

			if(currentTab == 2){
				if(document.getElementById('login').value == ''){
					document.getElementById('login').className = 'invalid';
					valid = false;
				}

				if(document.getElementById('senha').value == ''){
					document.getElementById('senha').className = 'invalid';
					valid = false;
				}

				if(document.getElementById('confirme_senha').value == ''){
					document.getElementById('confirme_senha').className = 'invalid';
					valid = false;
				}

				if(document.getElementById('confirme_senha').value != document.getElementById('senha').value){
					document.getElementById('senha').className = 'invalid';
					document.getElementById('confirme_senha').className = 'invalid';
					valid = false;	
					alert('Senha não confere!');
				}
			}

			return valid;
		}

		function fixStepIndicator(n) {
		    var i, x = document.getElementsByClassName("step");
		    for (i = 0; i < x.length; i++) {
		        x[i].className = x[i].className.replace(" active", "");
		    }
		    x[n].className += " active";
		}

		function salvarCandidato(tipo, id){
			id = (typeof id == "undefined")?'':id;
			var statusArr = {incluir:"adicionado",alterar:"alterado",deletar:"deletado"};			

			$.ajax({
				type: 'POST',
				url: 'api.php',
				data: {
					nome: document.getElementById('nome').value,
					email: document.getElementById('email').value,
					telefone: document.getElementById('telefone').value,
					experiencia: document.getElementById('experiencia').value,
					formacao: document.getElementById('formacao').value,
					login: document.getElementById('login').value,
					senha: document.getElementById('senha').value,
					acao: tipo,
					id: document.getElementById('id').value
				},
				success:function(msg){
					console.log(msg);
					if(msg == 'ok'){
						alert('Candidato foi '+statusArr[tipo]+' com sucesso.');						
					}else{
						alert('Ocorreu algum problema ao tentar salvar o registro.');
					}
					window.location.href = 'index.php';
				}
			});
		}
	</script>
</body>
</html>
