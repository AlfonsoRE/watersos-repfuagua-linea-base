package com.example.watersos.Activities;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.watersos.R;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    EditText edtUsuario, edtPassword;
    Button btnLogin;
    Button btnCuenta;
    String usuario, contrasena;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //llamamos los datos de la interfaz
        edtUsuario=findViewById(R.id.edtUsuario);
        edtPassword=findViewById(R.id.edtPassword);
        btnLogin=findViewById(R.id.btnLogin);
        btnCuenta=findViewById(R.id.btnCuenta);

        //le damos color a el titulo
        getSupportActionBar().setBackgroundDrawable(new ColorDrawable(getResources().getColor(R.color.toolbar)));

        //recuperamos los datos del usuario
        recuperarPreferencia();

        //borramos la base de datos de los reportes
        this.deleteDatabase("Reporte.db");

        //iniciamos sesion
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                //tomamos el usuario y contraseña de la interfaz
                usuario=edtUsuario.getText().toString();
                contrasena=edtPassword.getText().toString();

                //verificamos si los datos no estan vacios
                if (!usuario.isEmpty() && !contrasena.isEmpty()) {

                    //mandamos los datos al webservice
                    validarUsuario("http://192.168.1.66/RepWatOriginal/REPFUAGUA/php/validar_usuario.php");
                } else{

                    //si los datos estan vacios, se manda un mendaje de que los llenen
                    Toast.makeText(MainActivity.this , "No se permiten campos vacíos", Toast.LENGTH_LONG).show();
                }

            }
        });

        //boton para crear una nueva cuenta
        btnCuenta.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), CrearCuenta.class);
                startActivity(intent);

            }
        });
    }

    //metodo para iniciar sesion
    private void  validarUsuario (String URL){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, URL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                if (!response.isEmpty()) {

                    //guardamos los datos del usuario
                    guardarPreferencia();

                    //mandamos a la interfaz principal

                    Intent intent = new Intent(getApplicationContext(), Principal.class);
                    startActivity(intent);
                } else{

                    Toast.makeText(MainActivity.this, "El usuario y/o contraseña són incorrectos o bien usuario bloqueado", Toast.LENGTH_LONG).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(MainActivity.this, error.toString(), Toast.LENGTH_LONG).show();
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //guardmos los datos que se enviarn
                Map<String, String> parametros= new HashMap<String, String>();
                parametros.put("usuario",usuario);
                parametros.put("password",contrasena);
                return parametros;
            }
        };

        //mandamos los datos al webservice
        RequestQueue requestQueue= Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

    private void guardarPreferencia (){
        SharedPreferences preferences = getSharedPreferences("preferenciaLogin", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("usuario",usuario);
        editor.putString("contraseña",contrasena);
        editor.putBoolean("sesion",true);
        editor.commit();

    }

    private void recuperarPreferencia(){
        SharedPreferences preferences = getSharedPreferences("preferenciaLogin",Context.MODE_PRIVATE);
        edtUsuario.setText(preferences.getString("usuario",""));
        edtPassword.setText(preferences.getString("contraseña",""));

    }

}
