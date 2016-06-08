package com.biaz.safeparkingpro;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

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

public class MainActivity extends AppCompatActivity {
    int gId;

    @Bind(R.id.garageName)
    TextView garageName;

    @Bind(R.id.occupe)
    TextView occupe;

    @Bind(R.id.libre)
    TextView libre;

    @Bind(R.id.reserve)
    TextView reserve;

    @Bind(R.id.btnOccupe)
    ImageView btnOccupe;

    @Bind(R.id.btnLibre)
    ImageView btnLibre;

    @Bind(R.id.btnReserve)
    ImageView btnReserve;

    @Bind(R.id.btnNonReserve)
    ImageView btnNonReserve;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.bind(this);

        Intent intent = getIntent();
        gId = intent.getIntExtra("garageId", 0);
        String gName = intent.getStringExtra("garageName");

        garageName.setText(gName);
        loadGarageInformations();

        btnOccupe.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addPlace();
            }
        });

        btnLibre.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                subPlace();
            }
        });

        btnReserve.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addRes();
            }
        });

        btnNonReserve.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                subRes();
            }
        });
    }

    private boolean isConnected() {
        ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService
                (Activity.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected()) {
            return true;
        } else {
            return false;
        }
    }

    private void loadGarageInformations() {
        if (isConnected()) {

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/garage/" + gId;

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        } else {
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
        }
    }

    private void addPlace() {
        if (isConnected()) {

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/garage/" + gId+"/add";

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        } else {
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
        }
    }

    private void subPlace() {
        if (isConnected()) {

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/garage/" + gId+"/sub";

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        } else {
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
        }
    }

    private void addRes() {
        if (isConnected()) {

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/garage/" + gId+"/add/reserve";

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        } else {
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
        }
    }

    private void subRes() {
        if (isConnected()) {

            //Requête du serveur
            String serverURL =
                    "http://10.0.3.2/projet-stagedriss/App_Web/web/app_dev" +
                            ".php/safeparking/rest/garage/" + gId+"/sub/reserve";

            Log.e("URL", serverURL);

            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        } else {
            new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
                    (R.string.internetAlertMessage).setCancelable(false).setPositiveButton("Ok", new
                    DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    }).create().show();
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
        private ProgressDialog Dialog = new ProgressDialog(MainActivity.this);


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
         *
         * @param params
         * @return
         */
        @Override
        protected Void doInBackground(String... params) {
            try {
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
         *
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
            Log.e("TAG DE MERDE", reponse);
            int oc = JsonConverter.getOccupe(reponse);
            Log.e("TAG DE MERDE", oc+"");
            int free = JsonConverter.getLibre(reponse);
            Log.e("TAG DE MERDE", free+"");
            int res = JsonConverter.getReserve(reponse);
            Log.e("TAG DE MERDE", res+"");

            occupe.setText(oc+"");
            libre.setText(free+"");
            reserve.setText(res+"");
        }

    }
}
