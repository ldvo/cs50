/**
 * recover.c
 *
 * Computer Science 50
 * Problem Set 5
 *
 * Recovers JPEGs from a forensic image.
 */
 
#include <stdio.h>
#include <cs50.h>
#include <stdint.h>

int main(int argc, char* argv[])
{
    int block = 512;
    if (argc != 1)
    {
        printf("Please use ./recover");
        return 1;
    }
    FILE* file = fopen("card.raw", "r");
    FILE* file2 = NULL;
    if (file == NULL)
    {
        printf("Couldn't open file.");
        return 2;
    }
    uint8_t buffer[512];
    int count = 0;
    while (fread(buffer, block, 1, file) > 0)
    {
        if (buffer[0] == 0xff && buffer [1] == 0xd8 && buffer[2] == 0xff && (buffer[3] == 0xe0 || buffer[3] == 0xe1))
        {
            if (file2 != NULL)
                fclose(file2);
            char name[8];
            sprintf(name, "%03d.jpg", count);
            file2 = fopen(name, "w");
            count++;
            
        }
        if (file2 != NULL)
            fwrite(buffer, block, 1, file2);
    }
    if (file2 != NULL)
        fclose(file2);
    fclose(file);
    return 0;
}
