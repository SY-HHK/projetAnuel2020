package model;

import java.lang.reflect.Field;

public class Service {

    private String title;
    private float price;
    private String description;

    public Service(){
        super();
    }

    public Service(String title, float price, String description) {
        this.title = title;
        this.price = price;
        this.description = description;
    }

    public static String[] getAllVariable() {
        String[] array = new String[3];
        Field[] fields= Service.class.getDeclaredFields();
        for (int i = 0; i < fields.length; i++) {
            array[i] = fields[i].getName();
        }
        return array;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public float getPrice() {
        return price;
    }

    public void setPrice(float price) {
        this.price = price;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
}
