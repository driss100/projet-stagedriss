package com.biaz.safeparkingpro.utils;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by Hamza on 25/05/2016.
 */
public class JsonConverter {
    public static boolean ConnectionResponse(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        if(jsonObject.getString("message").equalsIgnoreCase("ok")){
            return true;
        }else{
            return false;
        }
    }
}
