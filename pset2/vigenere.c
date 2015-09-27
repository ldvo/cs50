#include <stdio.h>
#include <cs50.h>
#include <math.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    if (argc != 2)
    {
        printf("Please run ./vigenere (word) \n");
        return 1;
    }
    string k = argv[1];
    for (int i = 0, l = strlen(k); i < l; i++)
    {
        if (isalpha(k[i]) == false)
        {
            printf("Please run ./vigenere (word) \n");
            return 1;
        }
    }
    string p = GetString();
    int a = strlen(k), b = 0;
    for (int i = 0, n = strlen(p); i < n; i++)
    {
        if (isalpha(p[i]))
        {   
            if (islower(p[i]))
            {
                int z;
                if (islower(k[b]))
                {
                    z = k[b] - 'a';
                }
                else
                {
                    z = k[b] - 'A';
                }
                printf("%c", (((p[i] - 'a') + z ) % 26 ) + 'a');
                b++;
            }
            else
            {
                int z;
                if (islower(k[b]))
                {
                    z = k[b] - 'a';
                }
                else
                {
                    z = k[b] - 'A';
                }
                printf("%c", (((p[i] - 'A') + z ) % 26 ) + 'A');
                b++;
            }
            if ( b == a )
            {
                b = 0;
            }
        }
        else
        {
            printf("%c", p[i]);
        }
    }
    printf("\n");
}
