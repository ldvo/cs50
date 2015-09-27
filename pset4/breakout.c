//
// breakout.c
//
// Computer Science 50
// Problem Set 4
//

// standard libraries
#define _XOPEN_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <math.h>

// Stanford Portable Library
#include "gevents.h"
#include "gobjects.h"
#include "gwindow.h"

// height and width of game's window in pixels
#define HEIGHT 600
#define WIDTH 400

// number of rows of bricks
#define ROWS 5

// number of columns of bricks
#define COLS 10

// radius of ball in pixels
#define RADIUS 10

// lives
#define LIVES 3

// widhth and height of paddle in pixels
#define PHEIGHT 10
#define PWIDTH 80

// width and height of bricks
#define BHEIGHT 15
#define BWIDTH 32

// ball diameter
#define BDIAMETER 24

// prototypes
void initBricks(GWindow window);
GOval initBall(GWindow window);
GRect initPaddle(GWindow window);
GLabel initScoreboard(GWindow window);
void updateScoreboard(GWindow window, GLabel label, int points);
GObject detectCollision(GWindow window, GOval ball);

int main(void)
{
    // seed pseudorandom number generator
    srand48(time(NULL));

    // instantiate window
    GWindow window = newGWindow(WIDTH, HEIGHT);

    // instantiate bricks
    initBricks(window);

    // instantiate ball, centered in middle of window
    GOval ball = initBall(window);

    // instantiate paddle, centered at bottom of window
    GRect paddle = initPaddle(window);

    // number of bricks initially
    int bricks = COLS * ROWS;

    // number of lives initially
    int lives = LIVES;

    // number of points initially
    int points = 0;
    
    // instantiate scoreboard, centered in middle of window, just above ball
    GLabel label = initScoreboard(window);

    // ball x and y velocities

    double xvelocity = drand48();
    double yvelocity = 0.5;

    while (true)
    {
        GEvent click1 = getNextEvent(MOUSE_EVENT);

        if (click1 != NULL && getEventType(click1) == MOUSE_CLICKED)
        {
            break;
        }
    }
    
    // keep playing until game over
    while (lives > 0 && bricks > 0)
    {
        // move ball
        move(ball, xvelocity, yvelocity);
        
        // bounce ball off walls
        if (getX(ball) + BDIAMETER >= WIDTH)
        {
            xvelocity = -xvelocity;
        }
        else if (getX(ball) <= 0)
        {
            xvelocity = -xvelocity;
        }
        else if (getY(ball) + BDIAMETER >= HEIGHT)
        {
            yvelocity = -yvelocity;
        }
        else if (getY(ball) <= 0)
        {
            yvelocity = -yvelocity;
        }
        
        // move paddle with mouse
        GEvent mouse = getNextEvent(MOUSE_EVENT);
        if (mouse != NULL && getEventType(mouse) == MOUSE_MOVED)
        {
            if (getX(mouse) - PWIDTH / 2 >= 0 && getX(mouse) + PWIDTH / 2 <= WIDTH)
            {
                double x = getX(mouse) - PWIDTH / 2;
                double y = 575;
                setLocation(paddle, x, y);
            }
        }
        
        // detect collision of ball with GRect
        GObject object = detectCollision(window, ball);
        if (strcmp(getType(object), "GRect") == 0)
        {
            yvelocity = -yvelocity;
            // detect collision of ball with brick
            if (object != paddle)
            {
                removeGWindow(window, object);
                bricks--;
                points++;
                updateScoreboard(window, label, points);
                
            }
        }
        if (getY(ball) + BDIAMETER >= HEIGHT)
        {
            removeGWindow(window, ball);
            addAt(window, ball, (WIDTH/2)-(BDIAMETER/2), (HEIGHT/2)-(BDIAMETER/2));
            lives--;
            while (true)
            {
                GEvent click2 = getNextEvent(MOUSE_EVENT);

                if (click2 != NULL && getEventType(click2) == MOUSE_CLICKED)
                {
                    break;

                }
            }
        }
        pause(1);
        
        
    }

    // wait for click before exiting
    waitForClick();

    // game over
    closeGWindow(window);
    return 0;
}


/**
 * Initializes window with a grid of bricks.
 */
void initBricks(GWindow window)
{
    // creates array of bricks
    GRect brick[ROWS][COLS];
    
    for (int i = 0; i < ROWS; i++)
    {
        for (int g = 0; g < COLS; g++)
        {
            // creates brick
            
            brick[i][g] = newGRect(38 * g + 10, 30 * i + 20, BWIDTH, BHEIGHT);
            setFilled(brick[i][g], true);
            
            // sets collor according to row
            if (i == 0)
            {
                setColor(brick[i][g], "FF0000");
            }
            else if (i == 1)
            {
                setColor(brick[i][g], "FF9900");
            }
            else if (i == 2)
            {
                setColor(brick[i][g], "FFCC33");
            }
            else if (i == 3)
            {
                setColor(brick[i][g], "33CC00");
            }
            else if (i == 4)
            {
                setColor(brick[i][g], "0066FF");
            }
            
            // adds brick to window
            add(window, brick[i][g]);
        }
    }
}

/**
 * Instantiates ball in center of window.  Returns ball.
 */
GOval initBall(GWindow window)
{
    GOval ball = newGOval((WIDTH/2)-(BDIAMETER/2), (HEIGHT/2)-(BDIAMETER/2), BDIAMETER, BDIAMETER);
    setFilled(ball, true);
    setColor(ball, "#909090");
    add(window, ball);
    return ball;
}

/**
 * Instantiates paddle in bottom-middle of window.
 */
GRect initPaddle(GWindow window)
{
    GRect paddle = newGRect((WIDTH/2)-(PWIDTH/2), 575, PWIDTH, PHEIGHT);
    setFilled(paddle, true);
    setColor(paddle, "0066FF");
    add(window, paddle);
    return paddle;
}

/**
 * Instantiates, configures, and returns label for scoreboard.
 */
GLabel initScoreboard(GWindow window)
{
    char s[12];
    sprintf(s, "%i", 0);
    GLabel label = newGLabel("");
    setFont(label, "SansSerif-36");
    add(window, label);
    setLabel(label, s);
    double x = (WIDTH - getWidth(label)) / 2;
    double y = (HEIGHT - BDIAMETER * 2) / 2;
    setLocation(label, x, y);
    return label;
}

/**
 * Updates scoreboard's label, keeping it centered in window.
 */
void updateScoreboard(GWindow window, GLabel label, int points)
{
    // update label
    char s[12];
    sprintf(s, "%i", points);
    setLabel(label, s);

    // center label in window
    double x = (WIDTH - getWidth(label)) / 2;
    double y = (HEIGHT - BDIAMETER * 2) / 2;
    setLocation(label, x, y);
}

/**
 * Detects whether ball has collided with some object in window
 * by checking the four corners of its bounding box (which are
 * outside the ball's GOval, and so the ball can't collide with
 * itself).  Returns object if so, else NULL.
 */
GObject detectCollision(GWindow window, GOval ball)
{
    // ball's location
    double x = getX(ball);
    double y = getY(ball);

    // for checking for collisions
    GObject object;

    // check for collision at ball's top-left corner
    object = getGObjectAt(window, x, y);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's top-right corner
    object = getGObjectAt(window, x + 2 * RADIUS, y);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's bottom-left corner
    object = getGObjectAt(window, x, y + 2 * RADIUS);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's bottom-right corner
    object = getGObjectAt(window, x + 2 * RADIUS, y + 2 * RADIUS);
    if (object != NULL)
    {
        return object;
    }

    // no collision
    return NULL;
}

// Dedicado a Mariano Villarreal
