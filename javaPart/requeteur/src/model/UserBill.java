package model;

public class UserBill {

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

    public UserBill(String firstName, String lastName, String mail, String phone, String address, int idBill, String billDate, String billDescription, float billPrice, int billState, String billStripeId) {
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
}
