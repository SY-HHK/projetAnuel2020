package model;

public class Provider {

    private String firstName;
    private String lastName;
    private String mail;
    private String companyName;
    private String address;
    private String city;

    public Provider(){
        super();
    }

    public Provider(String firstName, String lastName, String mail, String companyName, String address, String city) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.mail = mail;
        this.companyName = companyName;
        this.address = address;
        this.city = city;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getMail() {
        return mail;
    }

    public void setMail(String mail) {
        this.mail = mail;
    }

    public String getCompanyName() {
        return companyName;
    }

    public void setCompanyName(String companyName) {
        this.companyName = companyName;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }
}
