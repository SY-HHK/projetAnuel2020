package model;

import java.lang.reflect.Field;

public class BillDeliveryProvider {

    private int idBill;
    private String billDate;
    private String billDescription;
    private float billPrice;
    private int billState;
    private String billStripeId;
    private int idDelivery;
    private int idService;
    private int idProvider;
    private String deliveryHourStart;
    private String getDeliveryHourEnd;
    private int deliveryState;
    private int deliveryRate;
    private String providerFirstName;
    private String providerLastName;
    private String providerMail;
    private String companyName;
    private String providerAddress;

    public BillDeliveryProvider(int idBill, String billDate, String billDescription, float billPrice, int billState, String billStripeId, int idDelivery, int idService, int idProvider, String deliveryHourStart, String getDeliveryHourEnd, int deliveryState, int deliveryRate, String providerFirstName, String providerLastName, String providerMail, String companyName, String providerAddress) {
        this.idBill = idBill;
        this.billDate = billDate;
        this.billDescription = billDescription;
        this.billPrice = billPrice;
        this.billState = billState;
        this.billStripeId = billStripeId;
        this.idDelivery = idDelivery;
        this.idService = idService;
        this.idProvider = idProvider;
        this.deliveryHourStart = deliveryHourStart;
        this.getDeliveryHourEnd = getDeliveryHourEnd;
        this.deliveryState = deliveryState;
        this.deliveryRate = deliveryRate;
        this.providerFirstName = providerFirstName;
        this.providerLastName = providerLastName;
        this.providerMail = providerMail;
        this.companyName = companyName;
        this.providerAddress = providerAddress;
    }

    public static String[] getAllVariable() {
        String[] array = new String[18];
        Field[] fields= BillDeliveryProvider.class.getDeclaredFields();
        for (int i = 0; i < fields.length; i++) {
            array[i] = fields[i].getName();
        }
        return array;
    }

    public int getIdBill() {
        return idBill;
    }

    public String getBillDate() {
        return billDate;
    }

    public String getBillDescription() {
        return billDescription;
    }

    public float getBillPrice() {
        return billPrice;
    }

    public int getBillState() {
        return billState;
    }

    public String getBillStripeId() {
        return billStripeId;
    }

    public int getIdDelivery() {
        return idDelivery;
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

    public String getProviderFirstName() {
        return providerFirstName;
    }

    public String getProviderLastName() {
        return providerLastName;
    }

    public String getProviderMail() {
        return providerMail;
    }

    public String getCompanyName() {
        return companyName;
    }

    public String getProviderAddress() {
        return providerAddress;
    }
}
