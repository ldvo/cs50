#include <math.h>
#include <cs50.h>
#include <stdio.h>

int main(void)
{
    printf("How much is owed?: ") ;
    float change = GetFloat() ;
    while ( change < 0 )
    {
        printf("How much is owed?: ") ;
        change = GetFloat() ;
    }
    change = change * 100 ;
    int cents = roundf(change) ;
    int total = 0 ;
    while ( cents > 24 )
    {
        cents = cents - 25 ;
        total++ ;
    }
    while ( cents > 9 )
    {
        cents = cents - 10 ;
        total++ ;
    }
    while ( cents > 4)
    {
        cents = cents - 5 ;
        total++ ;
    }
    while ( cents > 0 )
    {
        cents = cents - 1 ;
        total++ ;
    }
    printf("%d\n", total) ;
}
