#include <stdio.h>
#include <cs50.h>
#include <math.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    string p = GetString();
    string k = GetString();
    int b = 0;
    string a = k[b];
    int z = a - 'A';
    printf("%c", (((p[0] - 'A') + z ) % 26 ) - 'A');
}
