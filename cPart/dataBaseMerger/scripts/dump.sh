hote_db="localhost"
nom_bd="bringmeC"
login_db="admin"
pass_bd="test123"


col="companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, cityName, cityDepartment, cityRegion, providerGuid"
nom_table="PROVIDER INNER JOIN CITY ON PROVIDER.idCity = CITY.idCity"

rm "/home/hhk/Documents/projetAnuel2020/cPart/dataBaseMerger/merger/cmake-build-debug/backup.mdb"

mysql -h"$hote_db" -D"$nom_bd" -u "$login_db" -p"$pass_bd" -e "SELECT $col FROM $nom_table INTO OUTFILE '/var/www/html/backup.mdb' FIELDS TERMINATED BY ',';"

echo "Export terminé"

scp -i mdpScp script.sql user@51.75.133.145:~
