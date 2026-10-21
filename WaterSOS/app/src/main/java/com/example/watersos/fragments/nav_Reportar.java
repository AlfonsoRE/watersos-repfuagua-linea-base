package com.example.watersos.fragments;

import static android.app.Activity.RESULT_OK;

import android.Manifest;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.location.Address;
import android.location.Criteria;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.core.content.PermissionChecker;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.provider.MediaStore;
import android.provider.Settings;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.watersos.Activities.MainActivity;
import com.example.watersos.JavaClass.EnviarDatos;
import com.example.watersos.Objetos.Foto;
import com.example.watersos.Objetos.Reporte;
import com.example.watersos.R;
import com.example.watersos.SQLite.AdminSQLiteOpenHelper;

import com.example.watersos.ui.home.HomeFragment;

import java.io.IOException;
import java.net.URL;
import java.security.SecureRandom;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

/**
 * A simple {@link Fragment} subclass.
 */
public class nav_Reportar extends Fragment {

    //inicializamos los componentes que iran con la interfaz
    EditText edtNumContrato, edtNumExt,edtDireccion,edtDescripcion;
    Button enviar;
    ImageButton imgBtnFoto, imgBtnUbicacion;

    //creamos el bitmap en donde se guardara la imagen
    Bitmap bitmap;

    //booleadnos que nos direan si se a tomado una foto o no se a elegido la ubicacion
    Boolean imagenElegida = false;
    Boolean ubicacionElegida = false;

    AdminSQLiteOpenHelper baseDeDatos;

    double longitud, latitud;

    ProgressDialog progressDialog;

    int status =0;

    EnviarDatos enviarDatos;

    Activity activity;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        final View view = inflater.inflate(R.layout.fragment_nav__reportar, container,false);


        //vinculamos con la intefaz
        edtNumContrato = view.findViewById(R.id.edtNumContrato);
        edtNumExt = view.findViewById(R.id.edtNumExt);

        edtDireccion = view.findViewById(R.id.edtDireccion);
        edtDescripcion = view.findViewById(R.id.edtDescripcion);
        enviar =view.findViewById(R.id.enviar);
        imgBtnFoto = view.findViewById(R.id.imgBtnCamara);
        imgBtnUbicacion = view.findViewById(R.id.imgBtnUbicacion);



        //Toast.makeText(getActivity(), "Bienvenido a Reporte", Toast.LENGTH_LONG).show();

        enviarDatos=new EnviarDatos(getContext());

        progressDialog = new ProgressDialog(getContext());
        progressDialog.setMessage("Buscando dirección...");
        progressDialog.setCancelable(true);

        //llamamos la clase para generar la clave del reporte


        //llamamos la base de datos de sqlite
        baseDeDatos = new AdminSQLiteOpenHelper(getContext());

        //pedimos el permiso de camara y mandamos los datos por si deniegan el permiso
        if (ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED ) {

            //iniciamos la camra
            requestPermissions(new String[]{Manifest.permission.CAMERA},200);
            Toast.makeText(getContext(), "se denegaron", Toast.LENGTH_SHORT).show();

        }

        //pedimos el permiso de ubicacion y mandamos los datos por si deniegan el permiso
        if (ContextCompat.checkSelfPermission(getContext(),Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_DENIED){
            if (!ActivityCompat.shouldShowRequestPermissionRationale(getActivity(),Manifest.permission.ACCESS_FINE_LOCATION)){
                ActivityCompat.requestPermissions( getActivity(),new String[]{Manifest.permission.ACCESS_FINE_LOCATION},1);
            }
        }

        enviarDatos.enviarReporteConConexion();

        //boton de la foto
        imgBtnFoto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //verificamos si se tienen los permisos
                if (ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED ) {

                    requestPermissions(new String[]{Manifest.permission.CAMERA},200);
                    Toast.makeText(getActivity(), "se denegaron", Toast.LENGTH_SHORT).show();

                }
                //en caso de tener los permisos se efectuara esto que abrira la camara
                else{
                    Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    startActivityForResult(intent, 10);


                }
            }
        });


        //Toast.makeText(getActivity(), generateRandomString(5)+"", Toast.LENGTH_SHORT).show();

        //boton de la ubicacion
        imgBtnUbicacion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                //mandamos un false para que sepa que no se a buscado la direccion
                ubicacionElegida = false;
                
                //pedimos permiso en caso de que no se han permitido anteriormente
                if (ActivityCompat.checkSelfPermission(getContext(), Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

                    requestPermissions(new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 200);
                    Toast.makeText(getActivity(), "se denegaron", Toast.LENGTH_SHORT).show();

                } 
                //esto sucede en caso de que ya tengamos permiso
                else {

                    //iniciamos la pestaña de carga
                    progressDialog.show();
                    
                    //llamamos el locationManager para la direccion
                    LocationManager locationManager = (LocationManager) getActivity().getSystemService(Context.LOCATION_SERVICE);

                    //creamos un locationListener para consegir los datos de la ubicacion
                    LocationListener locationListener = new LocationListener() {
                        @Override
                        public void onLocationChanged(Location location) {

                            //en caso de que sea falsa se consegiran los dato
                            if (ubicacionElegida == false) {

                                //consegimos la latitud y latitud
                                latitud = location.getLatitude();
                                longitud = location.getLongitude();


                                try {

                                    //Toast.makeText(getContext(), "longitud: " + longitud + "\n latitud: " + latitud, Toast.LENGTH_SHORT).show();
                                    
                                    //se consigue la direccion
                                    Geocoder geocoder = new Geocoder(getActivity(), Locale.getDefault());
                                    //se consigue la direccion y se guarda en la lista
                                    List<Address> list = geocoder.getFromLocation(latitud, longitud, 1);
                                    //se verifica que la direccion no este vacia
                                    if (!list.isEmpty()) {
                                        //se jala los  datos de la lista
                                        Address DirCalle = list.get(0);
                                        //se muestra en la interfaz la direccion 
                                        edtDireccion.setText(DirCalle.getAddressLine(0));
                                        //decimos que ya se consigio la direccion
                                        ubicacionElegida = true;
                                        //hacemos visibles el edittext de la direcion
                                        edtDireccion.setVisibility(View.VISIBLE);
                                        progressDialog.dismiss();
                                    }


                                } catch (IOException e) {
                                    e.printStackTrace();
                                }
                            }


                        }

                        @Override
                        public void onStatusChanged(String s, int i, Bundle bundle) {

                        }

                        @Override
                        public void onProviderEnabled(String s) {

                        }

                        @Override
                        public void onProviderDisabled(String s) {

                        }
                    };


                    //mandamos el locationListiner para que se ejecute al 
                    locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0, 0, locationListener);
                }
            }

        });

        //boton para enviar los datos
        enviar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                
                //conseguimos la fecha y hora actual
                Date date = new Date();
                SimpleDateFormat formato= new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSS");
                String fechaYHora = formato.format(date.getTime());

                //conseguimos la clave que se le asinara al reporte
                final String clave = generateRandomString(5);

               //datos para verificar que se tiene internet
                ConnectivityManager connectivityManager = (ConnectivityManager) getContext().getSystemService(Context.CONNECTIVITY_SERVICE);
                NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();

                //verificamos que se ingreso un numero de contrato
                if (edtNumContrato.length() ==0){

                    Toast.makeText(getActivity(), "El numero de contrato no debe quedar vacío ",Toast.LENGTH_LONG).show();

                }

                //verificamos que se ingreso el numero exterion
                else if (edtNumExt.length()==0){
                    Toast.makeText(getActivity(), "El numero de exterior no debe quedar vacío ",Toast.LENGTH_LONG).show();

                }
                //verificamos que se ingreso una direccion
                else if (edtDireccion.length()==0){
                    Toast.makeText(getActivity(), "La dirección no debe quedar vacía ",Toast.LENGTH_LONG).show();

                }
                //verificamos que se ingreso alguna descripcion
                else if (edtDescripcion.length()==0){
                    Toast.makeText(getActivity(), "La descripción no debe quedar vacía ",Toast.LENGTH_LONG).show();
                }
                //verificamos que se toma alguna foto
                else if (imagenElegida == false){
                    Toast.makeText(getActivity(), "por favor tome una foto",Toast.LENGTH_LONG).show();
                }
                //verificamos que se consigio la longitud y latitud
                else if (ubicacionElegida == false){
                    Toast.makeText(getActivity(), "por favor tome una foto",Toast.LENGTH_LONG).show();
                }
                //se guarda si se ingresaron tolos dato
                else {
                    
                    //se consige el usuario
                    SharedPreferences preferences = getContext().getSharedPreferences("preferenciaLogin", Context.MODE_PRIVATE);
                    String usuario = preferences.getString("usuario", "");
                    
                    //se llama los objetos foto y reporte
                    Foto foto;
                    Reporte reporte;
                    
                    //se verfica si hay interne
                    if (networkInfo != null && networkInfo.isConnected()) {

                        //se guarda un status para la bd sqlite
                        status = 1;
                        //se guardanla datos en los objetos foto y reporte
                        foto = new Foto(clave, bitmap);
                        reporte = new Reporte(clave, edtDireccion.getText().toString(), fechaYHora, edtDescripcion.getText().toString(), "sin revisar", usuario, Integer.parseInt(edtNumContrato.getText().toString()), Integer.parseInt(edtNumExt.getText().toString()), status, latitud, longitud);
                       
                        //se crea un nombre para la imagen
                        Long consecutivo= System.currentTimeMillis()/1000;
                        String nombreImagen=consecutivo.toString()+".jpg";
                        
                        //se manda
                        enviarDatos.enviarDatosMysqlReporte("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/guardarReporte.php", reporte);
                        enviarDatos.enviarDatosMysqlFoto("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/guardarFoto.php",foto,nombreImagen);
                    }
                    else {
                        //se guarda un status para la bd sqlite
                        status = 0;
                        
                        //se guardanla datos en los objetos foto y reporte
                        foto = new Foto(clave, bitmap);
                        reporte = new Reporte(clave, edtDireccion.getText().toString(), fechaYHora, edtDescripcion.getText().toString(), "sin revisar", usuario, Integer.parseInt(edtNumContrato.getText().toString()), Integer.parseInt(edtNumExt.getText().toString()), status, latitud, longitud);

                    }
                    
                    //se vacian los edittext y se vuelce invicible el edittet de direccion
                    edtDescripcion.setText("");
                    edtDireccion.setText("");
                    edtDireccion.setVisibility(View.GONE);
                    edtNumContrato.setText("");
                    edtNumExt.setText("");

                    //se inician los bolean
                    imagenElegida= false;
                    ubicacionElegida=true;

                    //se vacia el bitmpa
                    bitmap =null;
                    
                    //se mandan los datos a la bd sqlite
                    enviarDatos.enviarDatosSQlite(reporte, foto);

                  

                    
                }

            }

        });



        return view;
    }
    
    //generamos la clave
    public static String generateRandomString(int length) {
        // Puede personalizar los personajes que desea agregar a
        // las cadenas al azar
        
        //guardamos las letras de que se podran crear la clave
        String DATA_FOR_RANDOM_STRING = "0123456789";
        
        //se crea la variable que se encarrgara de el numero random
        SecureRandom random = new SecureRandom();

        //verificamos que la clave no es menor que 1 y rn caso de serlo se marca error
        if (length < 1) throw new IllegalArgumentException();

        //creamos el constructor de string
        StringBuilder sb = new StringBuilder(length);

        //hacemos un for que ejecutara las mismas veces que el tamaño mandaddo
        for (int i = 0; i < length; i++) {
            // guardamos eldato a un char
            int rndCharAt = random.nextInt(DATA_FOR_RANDOM_STRING.length());
            char rndChar = DATA_FOR_RANDOM_STRING.charAt(rndCharAt);

            //se verifica se el caracter es 0 y la posicion es 0
            if (rndChar == '0' && i==0) {

                //se guardan un dato entre 1-9
                String datos="123456789";
                int datosAt= random.nextInt(datos.length());
                rndChar=datos.charAt(datosAt);
            }

            //se manda al string
            sb.append(rndChar);
        }

        //se retorna el string que sera la clave
        return sb.toString();
    }

    // consigue la imagen
    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode==10 && resultCode == RESULT_OK){

            //se consige la imagen
            bitmap = (Bitmap) data.getExtras().get("data");

            //se manda un true diciendo que ya se tomo una foto
            imagenElegida = true;
        }
    }
    
}
