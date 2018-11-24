var app = new Vue({

	el: "#principal",
	data: {
		errorMessage : "",
		successMessage : "",
		lista_candidatos: [],
		candidato: {nome: "", email: "", telefone: "", experiencia: "", formacao: "", login: "", senha: ""},
		clickedUser: {},
		
	},
	mounted: function () {
		this.ListarCandidatos();
	},
	methods: {
		ListarCandidatos: function(){
			axios.get("https://localhost/teste_selecty/api.php?acao=listar")
			.then(function(response){
				console.log(response);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.lista_candidatos = response.data.lista_candidatos;
				}
			});
		},
		salvarCandida:function(){

			var formData = app.toFormData(app.candidato);
			axios.post("https://localhost/teste_selecty/api.php?acao=incluir", formData)
			.then(function(response){
				console.log(response);
				app.candidato = {nome: "", email: "", telefone: "", experiencia: "", formacao: "", login: "", senha: ""};
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.successMessage = response.data.message;
					app.ListarCandidatos();
				}
			});
		},
			updateUser:function(){

			var formData = app.toFormData(app.clickedUser);
			axios.post("https://localhost/teste_selecty/api.php?acao=alterar", formData)
				.then(function(response){
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.ListarCandidatos();
					}
				});
			},
			deleteUser:function(){

			var formData = app.toFormData(app.clickedUser);
			axios.post("https://localhost/teste_selecty/api.php?acao=deletar", formData)
				.then(function(response){
					console.log(response);
					app.clickedUser = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.ListarCandidatos();
					}
				});
			},
			selectUser(user){
				app.clickedUser = user;
			},

			toFormData: function(obj){
				var form_data = new FormData();
			      for ( var key in obj ) {
			          form_data.append(key, obj[key]);
			      } 
			      return form_data;
			},
			clearMessage: function(){
				app.errorMessage = "";
				app.successMessage = "";
			},
		
	}
});