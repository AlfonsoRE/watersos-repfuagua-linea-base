package com.example.watersos.JavaClass;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Base64;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.watersos.Objetos.Foto;
import com.example.watersos.Objetos.Reporte;
import com.example.watersos.R;
import com.example.watersos.SQLite.AdminSQLiteOpenHelper;

import java.io.ByteArrayOutputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class EnviarDatos {

    //creamos una veriable de contexto
    Context context;

    //llamamos la clase que se encarga de la base de datos
    AdminSQLiteOpenHelper baseDeDatos;

    //inicializamos la clase
    public EnviarDatos(Context context) {
        this.context = context;
        baseDeDatos = new AdminSQLiteOpenHelper(context);
    }

    //metodo que enviara los reportes a guardar
    public void enviarDatosSQlite(Reporte reporte, Foto foto){

        //boleanos que muestran si se guardaron los datos correctamente a sqlite
        boolean insertFoto = baseDeDatos.insertarFoto(foto);
        boolean insertReporte = baseDeDatos.insertarReporte(reporte);

        //si los datos son correctos se mostrara un mensaje de registro
        if (insertFoto == true && insertReporte == true) {
            Toast.makeText(context, "registrado", Toast.LENGTH_SHORT).show();
        }

    }

    //metodo que envia los datos del reporte al webservice
    public void enviarDatosMysqlReporte (String URL, final Reporte reporte){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, error.toString(), Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //datos que se enviaran los datos al webservice
                Map<String , String> parametros = new HashMap<String, String>();
                parametros.put("clave_Reporte",reporte.getClave_Reporte());
                parametros.put("No_Contrato",reporte.getNO_Contrato()+"");
                parametros.put("No_Ext",reporte.getNO_Ext()+"");
                parametros.put("direccion",reporte.getDireccion());
                parametros.put("latitud",reporte.getLatitud()+"");
                parametros.put("longitud",reporte.getLongitud()+"");
                parametros.put("fecha",reporte.getFecha());
                parametros.put("descripcion",reporte.getDescripcion());
                parametros.put("seguimiento",reporte.getSeguimiento());
                parametros.put("usuario",reporte.getUsuario());

                return parametros;
            }
        };

        //se envian los datos al servidor
        RequestQueue requestQueue = Volley.newRequestQueue(context);
        requestQueue.add(stringRequest);
    }


    //metodo que envia los datos de la foto del reporte al webservice
    public void enviarDatosMysqlFoto (String URL, final Foto foto, final String nombreImagen){

        StringRequest stringRequest = new StringRequest(Request.Method.POST, URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, error.toString(), Toast.LENGTH_LONG).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
               //convertimos la imagen en un string
                String imagen = convertirImgString(foto.getFoto());

                //datos que se enviaran los datos al webservice
                Map<String , String> parametros = new HashMap<String, String>();
                parametros.put("clave",foto.getClave_Reporte());
                parametros.put("nombreImagen",nombreImagen);
                parametros.put("foto",imagen);

                return parametros;
            }
        };

        //se envian los datos al servidor
        RequestQueue requestQueue = Volley.newRequestQueue(context);
        requestQueue.add(stringRequest);
    }

    //metodo que convierte la imagen en un string
    private String convertirImgString(Bitmap bitmap) {

        ByteArrayOutputStream array= new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG,100,array);
        byte[] imagenByte = array.toByteArray();
        String imagenString = Base64.encodeToString(imagenByte,Base64.DEFAULT);

        return imagenString;
    }

    //metodo que enviara los datos cuando halla internet
    public void enviarReporteConConexion(){

        //consegimos los datos que tienen status 0 que verifica que no se a enviado al webservice
        ArrayList<Reporte> arrayList = baseDeDatos.verificarStatus();

        //variables que verifican que halla internet
        ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();

        //verificamos que halla internet
        if (networkInfo != null && networkInfo.isConnected()) {
            //ciclo que pasa que por los datos de la lista
            for (int i = 0; i < arrayList.size(); i++) {

                //variable reporte que guarda el reporte actual en el ciclo
                Reporte reporte = arrayList.get(i);

                //conseguimos la imagen de la base de datos
                Bitmap bitmap = baseDeDatos.conseguirImagen(reporte.getClave_Reporte());

                //creamos los datos
                Foto foto = new Foto(reporte.getClave_Reporte(),bitmap);

                //cambiamos el status del reporte
                baseDeDatos.actualizarEstatus(reporte.getClave_Reporte());

                //creamos nombre para la imgen actual
                Long consecutivo= System.currentTimeMillis()/1000;
                String nombreImagen=consecutivo.toString()+i+".jpg";

                //mandamos los datos del reporte al webservice
                enviarDatosMysqlReporte("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/guardarReporte.php",reporte);
                enviarDatosMysqlFoto("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/guardarFoto.php",foto,nombreImagen);


            }
        }

    }
}

