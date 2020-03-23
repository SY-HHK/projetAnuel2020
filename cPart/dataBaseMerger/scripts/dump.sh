MYSQL_PWD="test123" mysqldump --compact --insert-ignore --skip-triggers --no-create-db --no-create-info -u admin bringmeC > /home/hhk/Documents/projetAnuel2020/cPart/dataBaseMerger/scripts/script.sql

scp -i mdpScp script.sql user@51.75.133.145:~

