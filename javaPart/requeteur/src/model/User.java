package model;

import java.util.Date;

public class User {

    private String firstName;
    private String lastName;
    private String mail;
    private String address;
    private String city;
    private Date birth;

    public User(String firstName, String lastName, String mail, String address, String city, String birth) {
        super();
    }

    public User(String firstName, String lastName, String mail, String address, String city, Date birth) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.mail = mail;
        this.address = address;
        this.city = city;
        this.birth = birth;
    }



    public User(String firstName, String lastName, String mail, String address) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.mail = mail;
        this.address = address;
    }

    public User(String firstName, String lastName, String mail, String address, String city) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.mail = mail;
        this.address = address;
        this.city = city;
    }

    public Date getBirth() {
        return birth;
    }

    public void setBirth(Date birth) {
        this.birth = birth;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
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

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }
}
