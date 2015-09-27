#include <cs50.h>
#include <stdio.h>

int main(void)
{
    printf("Height:") ;
    int height = GetInt() ;
    while ( height < 0 || height > 23 )
    {
        printf("\nPlease try again:") ;
        height = GetInt() ;
    }
    for ( int row = 2; row < height + 2; row++ )
    {
        for ( int numspace = -1; numspace < height - row; numspace++ )
        {
            printf(" ") ;
        }
        for ( int numhash = 0; numhash != row; numhash++ )
        {
            printf("#") ;
        }
        printf("\n") ;
    }
}
