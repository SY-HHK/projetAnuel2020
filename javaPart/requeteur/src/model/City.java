package model;

public class City{

    private int cityId;
    private String cityName;
    private String cityRegion;
    private String cityDepartment;


    public City(){
        super();
    }

    public City(int cityId, String cityName, String cityRegion, String cityDepartment) {
        this.cityId = cityId;
        this.cityName = cityName;
        this.cityRegion = cityRegion;
        this.cityDepartment = cityDepartment;
    }

    public City(String cityName, String cityRegion, String cityDepartment) {
        this.cityName = cityName;
        this.cityRegion = cityRegion;
        this.cityDepartment = cityDepartment;
    }

    public int getCityId() {
        return cityId;
    }



    public void setCityId(int cityId) {
        this.cityId = cityId;
    }

    public String getCityName() {
        return cityName;
    }

    public void setCityName(String cityName) {
        this.cityName = cityName;
    }

    public String getCityRegion() {
        return cityRegion;
    }

    public void setCityRegion(String cityRegion) {
        this.cityRegion = cityRegion;
    }

    public String getCityDepartment() {
        return cityDepartment;
    }

    public void setCityDepartment(String cityDepartment) {
        this.cityDepartment = cityDepartment;
    }


}
