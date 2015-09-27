#include <stdio.h>
#include <cs50.h>
#include <math.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    if (argc != 2 || atoi(argv[1]) <=0 )
    {
        printf("Please run ./caesar (positive int) \n");
        return 1;
    }
    int k = atoi(argv[1]);
    string p = GetString();
    for (int i = 0, n = strlen(p); i < n; i++)
    {
        if (isupper(p[i]))
        {
            printf("%c", (((p[i] - 'A') + k) % 26) + 'A');
        }
        else if (islower(p[i]))
        {
            printf("%c", (((p[i] - 'a') + k) % 26) + 'a');
        }
        else
        {
            printf("%c", p[i]);
        }
    }
    printf("\n");
     
}


