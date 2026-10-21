<?php
include "conexion.php";

$clave=$_GET["clave_Reporte"];

$user_id=null;
$sql1= "select * from reporte where clave_Reporte = '$clave'";
$query = $db->query($sql1);
$reporte = null;
if($query->num_rows>0){
while ($r=$query->fetch_object()){
  $reporte=$r;
  $day= $reporte->seguimiento;
  $selected = ' selected="selected" ';
  break;
}

  }
?>

<?php if($reporte!=null):?>

<form role="form" id="actualizar" >
  <div class="form-group">
    <select id="seguimiento" name="seguimiento">
    <option value="1" <?php if($day=='Sin revisar') echo $selected; ?>>Sin revisar</option>
  	<option value="2" <?php if($day=='En proceso') echo $selected; ?>>En proceso</option>
   	<option value="3" <?php if($day=='Terminado') echo $selected; ?>>Terminado</option> 
</select>
  </div>
  
<input type="hidden" name="id" value="<?php echo $clave ?>">
  <button type="submit" class="btn btn-default">Actualizar</button>
</form>

<script>
    $("#actualizar").submit(function(e){
    e.preventDefault();
    $.post("./php/actualizar.php",$("#actualizar").serialize(),function(data){
    });
    alert("Actualización exitosa!");
    //$("#actualizar")[0].reset();
    $('#editModal').modal('hide');
   location.reload();
$('body').removeClass('modal-open');
$('.modal-backdrop').remove();
    loadTabla();
  });
</script>

<?php else:?>
  <p class="alert alert-danger">404 No se encuentra</p>
<?php endif;?>