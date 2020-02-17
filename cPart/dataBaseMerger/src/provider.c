#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <mysql/mysql.h>

#include "../include/struct.h"
#include "../include/database.h"


//Initialiser d'une structure de prestataire

Provider initProvider(char *fName, char *lName, int phone, char *email, char *pwd, char *addr, char *companyName, float rate, int annul ){

  Provider p;

  strcpy(p.providerFirstName, fName);
  strcpy(p.providerLastName, fName);
  p.providerPhone = phone;
  strcpy(p.providerEmail, email);
  strcpy(p.providerPassword, pwd);
  strcpy(p.providerAddress, addr);
  strcpy(p.companyName, companyName);
  p.providerRate = rate;
  p.prodviderAnnulation = annul;


printf("Le nom : %s\n Le prenom : %s\n Le num : %d\n L'email : %s\n Le mdp : %s\n L'addr : %s\n  L'entreprise: %s\n Le prix : %f\n L'annulation : %i\n  ", p.providerFirstName, p.providerLastName, p.providerPhone, p.providerEmail, p.providerPassword, p.providerAddress, p.companyName, p.providerRate, p.prodviderAnnulation);


  return p;

}

// Récupérer la liste de tous les prestataires

ProviderList listProvider(MYSQL *conn){

  ProviderList providers;
  MYSQL_RES *res;
  MYSQL_ROW row;
  int numRows;
  MYSQL_FIELD *fields;
  int cols;

  if (mysql_query(conn, "SELECT * FROM provider") != 0) {
    finish_with_err(conn);
  }

  res = mysql_store_result(conn);
  numRows = mysql_num_rows(res);
  fields = mysql_fetch_fields(res);
  cols = mysql_num_fields(res);

  for (int i = 0; i < cols; i++) {
    printf("[%s] ", fields[i].name);
  }

  printf("\n");

  providers.productArray = malloc(sizeof(Provider) * numRows);

  for (int i = 0; i < numRows; i++) {
    row = mysql_fetch_row(res);
providers.productArray[i] = initProvider(row[1], row[2], atoi(row[3]), row[4], row[5], row[6], row[7], atof(row[8]), atoi(row[9]));

  }

  providers.length = numRows;

  mysql_free_result(res);

  return providers;
}
