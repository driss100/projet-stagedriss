package com.biaz.safeparking;

import android.Manifest;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.util.Log;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONException;

import java.io.IOException;
import java.util.List;

public class MainActivity extends FragmentActivity implements OnMapReadyCallback {

    private GoogleMap mMap;

    private Marker myMarker;

    private LocationManager locationManager;

    private List garageMarkersList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        locationManager = (LocationManager) this.getSystemService(Context.LOCATION_SERVICE);

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        if(!isGPSEnabled()){
            displayMessage();
        }

        setUpMapIfNeeded();

        loadGarages();

    }

    private void loadGarages() {
        if (isConnected()) {
            //Requête du serveur
            String serverURL =
                    "http://192.168.1.16/projet-stagedriss/App_Web/web/app" +
                            ".php/safeparking/rest/garage/list";
            Log.e("URL", serverURL);
            //Crée l'objet LoadService et appelle la méthode d'exécution d'AsyncTask
            new LoadService().execute(serverURL);
        }else{
            new android.support.v7.app.AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).setTitle
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

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
    }

    private void setUpMapIfNeeded() {
        if (mMap == null) {
            //Try to obtain the map from the supportMapFragment
            mMap = ((SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map)).getMap();

            if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                // TODO: Consider calling
                //    ActivityCompat#requestPermissions
                // here to request the missing permissions, and then overriding
                //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
                //                                          int[] grantResults)
                // to handle the case where the user grants the permission. See the documentation
                // for ActivityCompat#requestPermissions for more details.
                return;
            }
            mMap.setMyLocationEnabled(true);
            //Check if we were succeful in obtaining the map
            if(mMap!= null){
                mMap.setOnMyLocationChangeListener(new GoogleMap.OnMyLocationChangeListener(){

                    @Override
                    public void onMyLocationChange(Location location) {
                        if(myMarker != null){
                            cleanMapFromMyMarker();
                        }
                        myMarker = mMap.addMarker(new MarkerOptions().position(new LatLng(location
                                .getLatitude(),
                                location.getLongitude())).title("Je suis là").icon(BitmapDescriptorFactory
                                .fromResource(R.mipmap.car)));
                        moveCamera();
                    }
                });
            }

        }
    }

    private void cleanMapFromMyMarker(){
        myMarker.remove();
    }

    private boolean isGPSEnabled(){
        if(locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)){
            return true;
        }else{
            return false;
        }
    }

    private void displayMessage(){
        new AlertDialog.Builder(this).setIconAttribute(android.R.attr.alertDialogIcon).
                setTitle(R.string.gpsDialogTitle).
                setMessage(R.string.gpsAlertMessage).setCancelable(false).setPositiveButton(R.
                string.enableGPS, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                Intent callGPSSettingIntent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                startActivity(callGPSSettingIntent);
            }
        }).create().show();
    }

    public void moveCamera(){
        CameraPosition cameraPosition = new CameraPosition.Builder()
                .target(myMarker.getPosition())
                .zoom(16)
                .bearing(90)
                .tilt(30)
                .build();
        mMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition), 3000, null);
    }


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
            List<Garage> garages = JsonConverter.parseResponse(reponse);

            if(garages.size() != 0){
                for (Garage garage : garages){
                    mMap.addMarker(new MarkerOptions().position(new LatLng(garage
                            .getLatitude(),
                            garage.getLongitude())).title(garage.getNom()).snippet("Nombre de place " +
                            "libre :"+garage.getLibre()).icon
                            (BitmapDescriptorFactory
                            .fromResource(R.mipmap.garagemarker)));
                }
            }

        }

    }

}
