var App = angular.module('app',[]);

App.controller('usuarioCtrl', function($scope, $http){
   $scope.usuario = {};
   $scope.ediusuario = {};
   $scope.usuarios = [];

    $scope.txtbuscar = {};

    $scope.guardarUsuario = function(){
      $http.post('./modelo/Usuario/guardarUsuario.php',$scope.usuario)
	     .success(function(data,status,headers,config){
         $scope.usuario = {};
         $('#myModal').click();
         $scope.consultarUsuarios();
	     }).error(function(data,status,headers,config){
	    	alert("Error BD");
	     });
    }

    $scope.editarUsuario = function(user){
      $scope.ediusuario = user;
      $scope.ediusuario.actualUsuario = user.usuario;
      $("#ediUsuario").modal("show");
    }

    $scope.ediUsuario = function(){
      $http.post('./modelo/Usuario/modificarUsuario.php',$scope.ediusuario)
      .success(function(data,status,headers,config){
        $scope.usuario = {};
        $scope.ediusuario ={};
        $('#ediUsuario').click();
        $scope.consultarUsuarios();
      }).error(function(data,status,headers,config){
       alert("Error BD");
      });

    }

    $scope.eliminarUsuario = function(user){
      var mensaje = confirm("¿Desea eliminar al usuario "+user.usuario+"?");
      if(mensaje){
        $http.post('./modelo/Usuario/eliminarUsuario.php',user)
        .success(function(data,status,headers,config){
          $scope.usuario = {};
          $scope.ediusuario ={};
          $scope.consultarUsuarios();
        }).error(function(data,status,headers,config){
         alert("Error BD");
        });
      }
    }

  $scope.consultarUsuarios = function(){
      $http.get('./modelo/Usuario/consultarUsuarios.php')
      .success(function(data,status,headers,config){
        $scope.usuarios=data;
      }).error(function(data,status,headers,config){
        alert("Error BD");
      });
    }

    $scope.buscar = function(){
      $http.post('./modelo/Usuario/buscarUsuarios.php',$scope.txtbuscar)
      .success(function(data,status,headers,config){
        $scope.usuarios=data;
      }).error(function(data,status,headers,config){
        alert("Error BD");
      });
    }
  
    $scope.consultarUsuarios();

});

App.controller('rolCtrl', function($scope, $http){
  $scope.rol = {};
  $scope.edirol = {};
  $scope.roles = [];

   $scope.txtbuscar = {};

   $scope.guardarRol = function(){
     $http.post('./modelo/Rol/guardarRol.php',$scope.rol)
      .success(function(data,status,headers,config){
        $scope.rol = {};
        $('#myModalrol').click();
        $scope.consultarRol();
      }).error(function(data,status,headers,config){
       alert("Error BD");
      });
   }

   $scope.editarRol = function(role){
     $scope.edirol = role;
     $scope.edirol.actualRol = role.nombre;
     $("#ediRol").modal("show");
   }

   $scope.ediRol = function(){
     $http.post('./modelo/Rol/modificarRol.php',$scope.edirol)
     .success(function(data,status,headers,config){
       $scope.rol = {};
       $scope.edirol ={};
       $('#ediRol').click();
       $scope.consultarRol();
     }).error(function(data,status,headers,config){
      alert("Error BD");
     });
   }

   $scope.eliminarRol = function(role){
     var mensaje = confirm("¿Desea eliminar al usuario "+role.nombre+"?");
     if(mensaje){
       $http.post('./modelo/Rol/eliminarRol.php',role)
       .success(function(data,status,headers,config){
         $scope.rol = {};
         $scope.ediRol ={};
         $scope.consultarRol();
       }).error(function(data,status,headers,config){
        alert("Error BD");
       });
     }
   }

 $scope.consultarRol = function(){
     $http.get('./modelo/Rol/consultarRol.php')
     .success(function(data,status,headers,config){
       $scope.roles=data;
     }).error(function(data,status,headers,config){
       alert("Error BD");
     });
   }

   $scope.buscar = function(){
    $http.post('./modelo/Rol/buscarRol.php',$scope.txtbuscar)
    .success(function(data,status,headers,config){
      $scope.roles=data;
    }).error(function(data,status,headers,config){
      alert("Error BD");
    });
  }
 
   $scope.consultarRol();

});

App.controller('productoCtrl', function($scope, $http){
  $scope.producto = {};
  $scope.ediproducto = {};
  $scope.productos = [];

  $scope.txtbuscar = {};

   $scope.guardarProducto = function(){
     $http.post('./modelo/Producto/guardarProducto.php',$scope.producto)
      .success(function(data,status,headers,config){
        $scope.producto = {};
        $('#myModalproducto').click();
        $scope.consultarProducto();
      }).error(function(data,status,headers,config){
       alert("Error BD");
      });
   }

   $scope.editarProducto = function(pro){
     $scope.ediproducto = pro;
     $scope.ediproducto.actualProducto = pro.codigo;
     $("#ediProducto").modal("show");
   }

   $scope.ediProducto = function(){
     $http.post('./modelo/Producto/modificarProducto.php',$scope.ediproducto)
     .success(function(data,status,headers,config){
       $scope.producto = {};
       $scope.ediproducto ={};
       $('#ediProducto').click();
       $scope.consultarProducto();
     }).error(function(data,status,headers,config){
      alert("Error BD");
     });

   }

   $scope.eliminarProducto = function(pro){
     var mensaje = confirm("¿Desea eliminar al usuario "+pro.nombre+"?");
     if(mensaje){
       $http.post('./modelo/Producto/eliminarProducto.php',pro)
       .success(function(data,status,headers,config){
         $scope.producto = {};
         $scope.ediproducto ={};
         $scope.consultarProducto();
       }).error(function(data,status,headers,config){
        alert("Error BD");
       });
     }
   }

 $scope.consultarProducto = function(){
     $http.get('./modelo/Producto/consultarProducto.php')
     .success(function(data,status,headers,config){
       $scope.productos=data;
     }).error(function(data,status,headers,config){
       alert("Error BD");
     });
   }

   $scope.buscar = function(){
    $http.post('./modelo/Producto/buscarProducto.php',$scope.txtbuscar)
    .success(function(data,status,headers,config){
      $scope.productos=data;
    }).error(function(data,status,headers,config){
      alert("Error BD");
    });
  }
 
   $scope.consultarProducto();

});