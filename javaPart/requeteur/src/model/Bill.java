package model;

public class Bill {

    private int idBill;
    private String billDate;
    private String billDescription;
    private float billPrice;
    private int billState;
    private String billStripeId;

    public Bill(int idBill, String billDate, String billDescription, float billPrice, int billState, String billStripeId) {
        this.idBill = idBill;
        this.billDate = billDate;
        this.billDescription = billDescription;
        this.billPrice = billPrice;
        this.billState = billState;
        this.billStripeId = billStripeId;
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
