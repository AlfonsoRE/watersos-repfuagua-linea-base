var App = angular.module('app',[]);

App.controller('indexCtrl', function($scope,$http){

$scope.usuario={};

$scope.guardar = function(){
	$http.post('./modelo/guardarUsuarioAlumno.php',$scope.usuario)
	.success(function(data,status,headers,config){
		$scope.usuario={};
		alert("Registrado");
        // setTimeout(function () {$scope.creaU = false;}, 1000);
	}).error(function(data,status,headers,config){
		alert("Error BD" + data);
	});
}

$scope.entro = function(){
	$('#pass').removeAttr('type');
}

$scope.salio = function(){
	$('#pass').attr('type','password');
}

});