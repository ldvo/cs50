/**
 * helpers.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Helper functions for Problem Set 3.
 */
       
#include <cs50.h>
#include <stdio.h>
#include <math.h>

#include "helpers.h"

/**
 * Returns true if value is in array of n values, else false.
 */
bool search(int value, int values[], int n)
{
    if ( n <= 0)
    {
    return false;
    }
    int start = 0;
    int ending = n - 1;
    int middle = 0;
    while ( ending >= start )
    {
        middle = round(( ending + start ) / 2);
        if ( values[middle] == value )
        {
            return true;
        }
        else if ( value > values[middle] )
        {
            start = middle + 1;
        }
        else 
        {
            ending = middle - 1;
        }
    }
    return false;
}

/**
 * Sorts array of n values.
 */
void sort(int values[], int n)
{
    int changes;
    do
    {
        changes = 0;
        for ( int i = 0; i < n; i++)
        {
        int a = i + 1;
        if (values[i] > values[a])
        {
            int x = values[i];
            int y = values[a];
            values[i] = y;
            values[a] = x;
            changes++;
        }
        }
    }
    while ( changes != 0);
    return;
}


