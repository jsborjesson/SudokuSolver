# Sudoku puzzles

Here are some puzzles that can easily be pasted in to test the application with.
Some of them are hard and will take a long time (or be interrupted) when solving
with a non-optimal algorithm. If that happens - just try the other one.

## Code

    $sudoku = new Sudoku(
        array(
            array(7, 2, 3, 0, 0, 0, 1, 5, 9),
            array(6, 0, 0, 3, 0, 2, 0, 0, 8),
            array(8, 0, 0, 0, 1, 0, 0, 0, 2),
            array(0, 7, 0, 6, 5, 4, 0, 2, 0),
            array(0, 0, 4, 2, 0, 7, 3, 0, 0),
            array(0, 5, 0, 9, 3, 1, 0, 4, 0),
            array(5, 0, 0, 0, 7, 0, 0, 0, 3),
            array(4, 0, 0, 1, 0, 3, 0, 0, 6),
            array(9, 3, 2, 0, 0, 0, 7, 1, 4)
        )
    );

## Visual

<http://www.mirror.co.uk/news/weird-news/worlds-hardest-sudoku-can-you-242294>

## Text

All of these are valid sudokus in text format. Some of them have to set the
zero character option. (Usually to dot `.`)

    003020600900305001001806400008102900700000008006708200002609500800203009005010300


    400000805
    030000000
    000700000
    020000060
    000080400
    000010000
    000603070
    500200000
    104000000


    43.8...29..27....1....2............3..45.28..7............9....2....76..19...5.78


    7 2 3 | . . . | 1 5 9
    6 . . | 3 . 2 | . . 8
    8 . . | . 1 . | . . 2
    - - -   - - -   - - -
    . 7 . | 6 5 4 | . 2 .
    . . 4 | 2 . 7 | 3 . .
    . 5 . | 9 3 1 | . 4 .
    - - -   - - -   - - -
    5 . . | . 7 . | . . 3
    4 . . | 1 . 3 | . . 6
    9 3 2 | . . . | 7 1 4




## File

Here is a [file](http://projecteuler.net/project/sudoku.txt) containing lots of them.
The regex for splitting this file is `Grid.*\n`.
