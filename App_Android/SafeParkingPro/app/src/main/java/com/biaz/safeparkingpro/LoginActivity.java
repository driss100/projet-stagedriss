package com.biaz.safeparkingpro;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import com.biaz.safeparkingpro.utils.JsonConverter;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONException;

import java.io.IOException;

import butterknife.Bind;
import butterknife.ButterKnife;

public class LoginActivity extends AppCompatActivity {

    String email;
    String password;

    @Bind(R.id.btn_login)
    Button loginButton;

    @Bind(R.id.input_email)
    EditText emailText;

    @Bind(R.id.input_password)
    EditText passwordText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ButterKnife.bind(this);

        deleteActionBar();
        loadBtnLoginListener();
    }

    public void deleteActionBar() {
        getSupportActionBar().hide();
    }

    public void loadBtnLoginListener() {
        loginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login();
            }
        });
    }

    private void login() {
        if (isConnected()){
            //Récupération des informations
            email = String.valueOf(emailText.getText()).trim();
            password = String.valueOf(passwordText.getText()).trim();

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/gardien/"+email+"/"+password;

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        }else{
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
        }
    }

    private boolean isConnected() {
        ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService
                (Activity.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
        if(networkInfo != null && networkInfo.isConnected()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Cette classe permet de lancer une tâche asynchrone
     */
    private class LoadService extends AsyncTask<String, Void, Void> {


        //Le client Http qui va faire appel à la requête
        private final HttpClient Client = new DefaultHttpClient();

        //Variable qui contiendra ma réponse
        private String reponse;

        //Variable pour la gestion d'erreur
        private String error = null;

        //Un TAG vide juste pour le log
        private final String TAG = null;

        //Boite de dialogue avec un loader (pour la progression)
        private ProgressDialog Dialog = new ProgressDialog(LoginActivity.this);


        /**
         * Cette fonction s'exécute avant de lancer la tâche
         * En gros on affiche le message d'attente
         */
        @Override
        protected void onPreExecute() {

            Dialog.setMessage("Veuillez patienter ...");
            Dialog.show();
        }

        /**
         * Cette fonction exécute la tâche de fond soit en gros l'appel du service
         * @param params
         * @return
         */
        @Override
        protected Void doInBackground(String... params) {
            try{
                //Je définis une requête Get avec le premier argument qui est l'url
                HttpGet httpGet = new HttpGet(params[0]);

                //Je définis un handler string pour ma réponse
                ResponseHandler<String> responseHandler = new BasicResponseHandler();

                //Je demande au client d'exécuter la requête et je lui passe le handler pour avoir la réponse
                reponse = Client.execute(httpGet, responseHandler);
            } catch (ClientProtocolException e) {
                error = e.getMessage();
                cancel(true);
            } catch (IOException e) {
                error = e.getMessage();
                cancel(true);
            }
            return null;
        }

        /**
         * Cette fonction s'exécute après reception de du résultat
         * @param aVoid
         */
        protected void onPostExecute(Void aVoid) {
            //fermer la boite de dialogue
            Dialog.dismiss();
            try {
                responseHandler(reponse);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            //new AlertDialog.Builder(SignUpActivity.this).setTitle("Réponse").setMessage(reponse).show();
        }


        public void responseHandler(String reponse) throws JSONException {
            boolean found = JsonConverter.ConnectionResponse(reponse);
            if(found){
                AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
                builder.setTitle("Connexion").setMessage("Connexion réussie!")
                        .setCancelable(false)
                        .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {

                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();
            }else{
                AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
                builder.setTitle("Problème de connexion").setMessage("Veuillez vérifier vos identifiants de connexion!")
                        .setCancelable(false)
                        .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {

                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();
            }
        }

    }
}
