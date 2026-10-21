package com.example.watersos.fragments;

import static android.content.ContentValues.TAG;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.ImageRequest;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.example.watersos.Adapters.AdapterReportes;
import com.example.watersos.JavaClass.EnviarDatos;
import com.example.watersos.Objetos.Foto;
import com.example.watersos.Objetos.Reporte;
import com.example.watersos.R;
import com.example.watersos.SQLite.AdminSQLiteOpenHelper;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;

public class nav_misReportes extends Fragment {

    //vtrsmod un recyclerview
    RecyclerView recyclerView;

    //creamos un arraylist del tipo reporte
    ArrayList<Reporte> reporteArrayList;
    //creamos un objeto del adapter de laos reportes
    AdapterReportes adapterReportes;
    //llamamos la base de datos
    AdminSQLiteOpenHelper baseDeDatos;

    //llamamos los datos de eviar dato
    EnviarDatos enviarDatos;

    //creamos un layout de refrescar
    SwipeRefreshLayout rlReportes;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        final View view =inflater.inflate(R.layout.fragment_nav_mis_reportes, container, false);
        //inicilizmos enviar dato y se envian los dato que no se an podido con conexion
        enviarDatos = new EnviarDatos(getContext());
        enviarDatos.enviarReporteConConexion();

        //llamamos los objetos de el layout
        recyclerView = view.findViewById(R.id.idRecyclerReportes);
        rlReportes = view.findViewById(R.id.refreshListaReporte);

        //inicializamos la base de datos
        baseDeDatos = new AdminSQLiteOpenHelper(getActivity());

        //inicializamos el arraylist
        reporteArrayList = new ArrayList<>();

        //llamamos el metodo verificar con
        verificarConexion();

        //hacemos el comportaminto al refrescar
        rlReportes.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                verificarConexion();
            }
        });



        return view;
    }



    //se obtienen los reportes del webservice
    public void obtenerDatosReporte(String URL){

        //inicializamos el refresh layout y vaciamos el arraylist
        rlReportes.setRefreshing(true);
        reporteArrayList.clear();

        //llamamos las datos de webservice
        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(URL, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {

                JSONObject jsonObject =null;
                for (int i = 0; i < response.length(); i++) {
                    try {

                        jsonObject = response.getJSONObject(i);

                        //consegimos los datos de la base de datos mysql
                        String clave_Reporte = jsonObject.getString("clave_Reporte");
                        String direccion = jsonObject.getString("direccion");
                        String fecha = jsonObject.getString("fecha");
                        String descripcion = jsonObject.getString("descripcion");
                        String seguimiento = jsonObject.getString("seguimiento");
                        String usuario = jsonObject.getString("usuario");
                        int No_Contrato = jsonObject.getInt("No_Contrato");
                        int No_Ext = jsonObject.getInt("No_Ext");
                        int estatus = 1;
                        double latitud = jsonObject.getDouble("latitud");
                        double longitud = jsonObject.getDouble("longitud");

                        //mandamos datos para consegir las fotos
                        obtenerDatosFoto("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/consultarFoto.php?clave="+clave_Reporte,clave_Reporte);
                        //guardamos los datos en sqlite
                        baseDeDatos.insertarReporte(new Reporte(clave_Reporte,direccion,fecha,descripcion,seguimiento,
                                usuario,No_Contrato,No_Ext,estatus,latitud,longitud));
                    } catch (JSONException e) {
                        Toast.makeText(getContext(), "error "+e.getMessage(), Toast.LENGTH_SHORT).show();
                    }

                }

               

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        //ejecutamos la consulta
        RequestQueue requestQueue = Volley.newRequestQueue(getContext());
        requestQueue.add(jsonArrayRequest);
    }

    public void obtenerDatosFoto(String URL, final String clave){

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(URL, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {

                JSONObject jsonObject =null;
                for (int i = 0; i < response.length(); i++) {
                    try {
                        jsonObject = response.getJSONObject(i);

                        //consegimos los datos del webservice
                        String foto = jsonObject.getString("foto");

                        //creamos el enlace de la imagen
                        String enlace= "http://192.168.1.66/RepWatOriginal/REPFUAGUA/"+foto;

                        //mandamos para que se descage la imagen y se guarde en sqlite
                        descargarImagen(enlace, clave);


                    } catch (JSONException e) {
                        Toast.makeText(getContext(), "error "+e.getMessage(), Toast.LENGTH_SHORT).show();
                    }

                }

                //se termina de refrescar y se muestran los datos
                rlReportes.setRefreshing(false);
                mostrarDatosSqlite();

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        RequestQueue requestQueue = Volley.newRequestQueue(getActivity());
        requestQueue.add(jsonArrayRequest);
    }

    //decargamos las imagenetes y los guardamos en sqlite
    public void descargarImagen(String url, final String clave) {

        //llamamos la imagen de la url
        ImageRequest peticion = new ImageRequest(
                url,
                new Response.Listener<Bitmap>() {
                    @Override
                    public void onResponse(Bitmap response) {
                        //guardamos los datos de la url
                        baseDeDatos.insertarFoto(new Foto(clave,response));
                    }
                }, 0, 0, null, // maxWidth, maxHeight, decodeConfig
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
        );
        //ejecutamos la peticion de la descarga de la imgen
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity());
        requestQueue.add(peticion);

    }

    //mostramos ls datos en la pantall
    public void mostrarDatosSqlite(){
        reporteArrayList = baseDeDatos.mostraReportes();
        adapterReportes = new AdapterReportes(getContext(), reporteArrayList);
        recyclerView.setAdapter(adapterReportes);
    }

    public void verificarConexion(){
        //consegimos los datos del usuario
        SharedPreferences preferences = getContext().getSharedPreferences("preferenciaLogin",Context.MODE_PRIVATE);
        String usuario =preferences.getString("usuario","");

        //lamamos las varibles para verificar la conexion
        ConnectivityManager connectivityManager = (ConnectivityManager) getContext().getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();

        //verificamos si hay conexion a internet
        if (networkInfo != null && networkInfo.isConnected()) {

            //vaciamos la tablas
            baseDeDatos.borrarDatosTablaReporte();
            baseDeDatos.borrarDatosTablaFoto();

            //obtenemos los datos del webservice
            obtenerDatosReporte("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/consultarReporte.php?usuario="+usuario);
            rlReportes.setRefreshing(false);
        }else {

            //en caso de no haber conexion se muestran los guardados en sqlite
            rlReportes.setRefreshing(true);
            mostrarDatosSqlite();
            rlReportes.setRefreshing(false);
        }
    }
}
