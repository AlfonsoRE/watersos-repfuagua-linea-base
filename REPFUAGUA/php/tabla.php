<?php

include "conexion.php";

$user_id=null;
$sql1= "select * from reporte ORDER BY fecha DESC";
$query = $db->query($sql1);
?>

<?php if($query->num_rows>0):?>
	<div id="tabla_fecha">
<table class="table table-bordered table-hover">
<thead>
    <th>Clave Reporte</th>
	<th>No. de Contrato</th>
	<th>No. Ext</th>
	<th>Dirección</th>
	<th>Ubicación</th>
	<th>Evidencia</th>
	<th>Fecha</th>
	<th>Descripción</th>
	<th>Status</th>
	<th>Usuario</th>
	<th>Acciones</th>
</thead>
<?php while ($r=$query->fetch_array()):?>
<tr>
	<td><?php echo $r["clave_Reporte"]; ?></td>
	<td><?php echo $r["No_Contrato"]; ?></td>
	<td><?php echo $r["No_Ext"]; ?></td>
	<td><?php echo $r["direccion"]; ?></td>
	<td><a href="https://www.google.es/maps/place/<?php echo $r["latitud"];?>,<?php echo $r["longitud"]; ?>" target="_blank">Localización</a> </td>
	<td><a href="./verimagen.php?clave_Reporte=<?php echo $r["clave_Reporte"] ;?>" target="_blank">fotos</a> </td>

	<td><?php echo $r["fecha"]; ?></td>
	<td><?php echo $r["descripcion"]; ?></td>
	<td><?php echo $r["seguimiento"]; ?></td>
	<td><?php echo $r["usuario"]; ?></td>
	<td style="width:150px;">
		<a data-id="<?php echo $r["clave_Reporte"];?>" class="btn btn-edit btn btn-success">Status</a>
		<a href="#"  id="del-<?php echo $r["clave_Reporte"];?>" class="btn btn-sm btn-danger">Eliminar</a>
		<script>
		$("#del-"+<?php echo $r["clave_Reporte"];?>).click(function(e){
			e.preventDefault();
			p = confirm("Estas seguro?");
			if(p){
				$.get("./php/eliminar.php","clave_Reporte="+<?php echo $r["clave_Reporte"];?>,function(data){
					alert("Eliminado exitosamente.");
					location.reload();
				});
			}

		});
		</script>
	</td>
</tr>
<?php endwhile;?>
</table>
<?php else:?>
	<p class="alert alert-warning">No hay resultados</p>
<?php endif;?>
  <!-- Modal -->
  <script>
  	$(".btn-edit").click(function(){
  		id = $(this).data("id");
  		$.get("./php/formulario.php","clave_Reporte="+id,function(data){
  			$("#form-edit").html(data);
			  
  		});
  		$("#editModal").modal("show");
  	});

  </script>
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Actualizar</h4>
        </div>
        <div class="modal-body">
        <div id="form-edit"></div>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->