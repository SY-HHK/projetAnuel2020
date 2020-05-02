package model;

public class UserBillDelivery {

    private String firstName;
    private String lastName;
    private String mail;
    private String phone;
    private String address;
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

    public UserBillDelivery(String firstName, String lastName, String mail, String phone, String address, int idBill, String billDate, String billDescription, float billPrice, int billState, String billStripeId, int idDelivery, int idService, int idProvider, String deliveryHourStart, String getDeliveryHourEnd, int deliveryState, int deliveryRate) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.mail = mail;
        this.phone = phone;
        this.address = address;
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
    }

    public String getFirstName() {
        return firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public String getMail() {
        return mail;
    }

    public String getPhone() {
        return phone;
    }

    public String getAddress() {
        return address;
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
}
