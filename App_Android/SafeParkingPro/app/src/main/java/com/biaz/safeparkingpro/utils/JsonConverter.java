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

    public static String getGarageName(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        return jsonObject.getString("garage");
    }

    public static int getGarageId(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        return jsonObject.getInt("id");
    }

    public static int getOccupe(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        return jsonObject.getInt("occupe");
    }

    public static int getLibre(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        return jsonObject.getInt("libre");
    }

    public static int getReserve(String response) throws JSONException{
        JSONObject jsonObject = new JSONObject(response);
        return jsonObject.getInt("reserve");
    }
}
