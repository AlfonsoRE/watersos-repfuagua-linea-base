var App = angular.module('app', []);
App.controller('maestroCtrl', function($scope, $http) {
    $scope.maestro = {};
    $scope.maestros = [];
    $scope.banMod = false;
    $scope.banAlt = true;

    $scope.altaMaestro = function() {
        $scope.maestros.push($scope.maestro);
        $scope.maestro = {};
        alert("--Agregado--");
    }

    $scope.seleccionarMaestro = function(m) {
        $scope.maestro = m;
        $scope.banMod = true;
        $scope.banAlt = false;
    }

    $scope.modificarMaestro = function() {
        $scope.maestro = {};
        $scope.banMod = false;
        $scope.banAlt = true;
    }

    $scope.eliminarMaestro = function(i) {
        $scope.maestros.splice(i, 1);
    }

});