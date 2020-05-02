package model;

public class Delivery {

    private int idDelivery;
    private int idBill;
    private int idService;
    private int idProvider;
    private String deliveryHourStart;
    private String getDeliveryHourEnd;
    private int deliveryState;
    private int deliveryRate;

    public Delivery(int idDelivery, int idBill, int idService, int idProvider, String deliveryHourStart, String getDeliveryHourEnd, int deliveryState, int deliveryRate) {
        this.idDelivery = idDelivery;
        this.idBill = idBill;
        this.idService = idService;
        this.idProvider = idProvider;
        this.deliveryHourStart = deliveryHourStart;
        this.getDeliveryHourEnd = getDeliveryHourEnd;
        this.deliveryState = deliveryState;
        this.deliveryRate = deliveryRate;
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
}
