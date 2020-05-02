package model;

public class DeliveryProviderService {

    private int idDelivery;
    private int idBill;
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
    private String title;
    private int price;
    private String description;

    public DeliveryProviderService(int idDelivery, int idBill, int idService, int idProvider, String deliveryHourStart, String getDeliveryHourEnd, int deliveryState, int deliveryRate, String providerFirstName, String providerLastName, String providerMail, String companyName, String providerAddress, String title, int price, String description) {
        this.idDelivery = idDelivery;
        this.idBill = idBill;
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
        this.title = title;
        this.price = price;
        this.description = description;
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

    public String getTitle() {
        return title;
    }

    public int getPrice() {
        return price;
    }

    public String getDescription() {
        return description;
    }
}
