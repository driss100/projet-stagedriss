package com.biaz.safeparking;

/**
 * Created by Hamza on 25/06/2016.
 */
public class Garage {

    public String nom ;

    public double latitude;

    public double longitude;

    public int reserve;
    public int occupe;
    public int libre;

    public Garage(String nom, double latitude, double longitude, int reserve, int occupe, int libre) {
        this.nom = nom;
        this.latitude = latitude;
        this.longitude = longitude;
        this.reserve = reserve;
        this.occupe = occupe;
        this.libre = libre;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public double getLatitude() {
        return latitude;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public void setLongitude(double longitude) {
        this.longitude = longitude;
    }

    public int getReserve() {
        return reserve;
    }

    public void setReserve(int reserve) {
        this.reserve = reserve;
    }

    public int getOccupe() {
        return occupe;
    }

    public void setOccupe(int occupe) {
        this.occupe = occupe;
    }

    public int getLibre() {
        return libre;
    }

    public void setLibre(int libre) {
        this.libre = libre;
    }
}
