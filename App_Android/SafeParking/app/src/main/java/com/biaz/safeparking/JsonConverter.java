package com.biaz.safeparking;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Hamza on 25/06/2016.
 */
public class JsonConverter {
    public static List<Garage> parseResponse(String resp) throws JSONException {
        List <Garage> garages = new ArrayList<>();
        JSONArray jsonArray = new JSONArray(resp);
        for(int i=0; i<jsonArray.length(); i++){
            JSONObject object = jsonArray.getJSONObject(i);
            Garage garage = new Garage(object.getString("nom"), object.getDouble("latitude"), object
                    .getDouble("longitude"), object.getInt("reserve"), object.getInt("occupe"), object
                    .getInt("libre"));
            garages.add(garage);
        }
        return garages;
    }
}
