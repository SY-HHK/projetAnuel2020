#ifndef STRUCT_HEADER
#define STRUCT_HEADER

#include <gtk/gtk.h>

typedef struct Provider{
  char providerFirstName[256];
  char providerLastName[256];
  int providerPhone;
  char providerEmail[256];
  char providerPassword[256];
  char providerAddress[256];
  char companyName[256];
  double providerRate;
  int prodviderAnnulation;
} Provider;

typedef struct ProviderList{
  Provider *productArray;
  int length;
} ProviderList;


#endif
