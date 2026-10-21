<?php
//filtro.php
if(isset($_POST["from_date"], $_POST["to_date"])){
    $connect = mysqli_connect("localhost", "root", "", "itsavedu_WaterSOS");  
    $output = '';
    $query = "SELECT * FROM reporte
        WHERE fecha BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ORDER BY `fecha` ASC";
    $result = mysqli_query($connect,$query);
    $output .= '
    <table class="table table-bordered table-hover">
    <tr>
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
    </tr>
    ';
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $output .= '
            <tr>
            <td>'. $row["clave_Reporte"] .'</td>
            <td>'. $row["No_Contrato"] .'</td>
            <td>'. $row["No_Ext"] .'</td>
            <td>'. $row["direccion"] .'</td>
            <td><a href="https://www.google.es/maps/place/<'. $row["latitud"].','. $row["longitud"] .'" target="_blank">Localización</a> </td>
            <td><a href="./verimagen.php?clave_Reporte='. $row["clave_Reporte"].'" target="_blank">fotos</a> </td>
            <td>'. $row["fecha"] .'</td>
            <td>'. $row["descripcion"] .'</td>
            <td>'. $row["seguimiento"] .'</td>
            <td>'. $row["usuario"] .'</td>
            <td style="width:150px;">
                <a data-id="'. $row["clave_Reporte"].'" class="btn btn-edit btn-sm btn-warning">Status</a>
                <a href="#"  id="del-'.$row["clave_Reporte"].'" class="btn btn-sm btn-danger">Eliminar</a>
                <script>
                $("#del-"+'.$row["clave_Reporte"].').click(function(e){
                    e.preventDefault();
                    p = confirm("Estas seguro?");
                    if(p){
                        $.get("./php/eliminar.php","clave_Reporte="+'.$row["clave_Reporte"].',function(data){
                            alert("Eliminado exitosamente.");
                            
                        });
                    }
        
                });
                </script>
            </td>
        </tr>

        

            ';

        
            
        }
    }else{
        $output .= '
            <tr>
                <td colspan="5">No se encontro rango</td>
            </tr>
        ';
    }
    $output .= '</table>';
    echo $output;
}
?>