#ifndef FRIDGE_HEADER
#define FRIDGE_HEADER

Provider initProvider(char *fName, char *lName, int phone, char *email, char *pwd, char *addr, char *companyName, float rate, int annul );
ProviderList listProvider(MYSQL *conn);

#endif
