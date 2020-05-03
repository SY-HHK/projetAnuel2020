package model;

import java.lang.reflect.Field;

public class DeliveryService {

    private int idDelivery;
    private int idBill;
    private int idService;
    private int idProvider;
    private String deliveryHourStart;
    private String getDeliveryHourEnd;
    private int deliveryState;
    private int deliveryRate;
    private String title;
    private float price;
    private String description;

    public DeliveryService(int idDelivery, int idBill, int idService, int idProvider, String deliveryHourStart, String getDeliveryHourEnd, int deliveryState, int deliveryRate, String title, float price, String description) {
        this.idDelivery = idDelivery;
        this.idBill = idBill;
        this.idService = idService;
        this.idProvider = idProvider;
        this.deliveryHourStart = deliveryHourStart;
        this.getDeliveryHourEnd = getDeliveryHourEnd;
        this.deliveryState = deliveryState;
        this.deliveryRate = deliveryRate;
        this.title = title;
        this.price = price;
        this.description = description;
    }

    public static String[] getAllVariable() {
        String[] array = new String[11];
        Field[] fields= DeliveryService.class.getDeclaredFields();
        for (int i = 0; i < fields.length; i++) {
            array[i] = fields[i].getName();
        }
        return array;
    }

    public int getIdDelivery() {
        return idDelivery;
    }

    public int getIdBill() {
        return idBill;
    }

    public int getIdService() {
        return idService;
    }

    public int getIdProvider() {
        return idProvider;
    }

    public String getDeliveryHourStart() {
        return deliveryHourStart;
    }

    public String getGetDeliveryHourEnd() {
        return getDeliveryHourEnd;
    }

    public int getDeliveryState() {
        return deliveryState;
    }

    public int getDeliveryRate() {
        return deliveryRate;
    }

    public String getTitle() {
        return title;
    }

    public float getPrice() {
        return price;
    }

    public String getDescription() {
        return description;
    }
}
