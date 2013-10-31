# Outlines the practical usage of the application

There are 3 different ways of submittin sudokus to be solved, and 2 different
solving algorithms to choose from.

## Visual input

This is the most straight forward way of solving a sudoku. Just input
the puzzle and click `Solve`! You can use the arrow keys to move around
in the grid.

## Text input

Here you can input text that will be parsed into one or more sudoku puzzles.
There are a bunch of examples of how the text can be formatted in the document
[TestingSudokus](TestingSudokus.md).

### Optional settings

If you input a sudoku where the empty cells are not represented as the digit `0`,
but instead with, for example a dot `.`, you will need to set the *empty character*
option to `.`.

You can input multiple textual sudokus at once, but you have to provide a way
to separate the puzzles from each other. For this, you use the *delimiter* option.
The delimiter is the string that will split the text into multiple sudokus, and
it supports regular expressions!

If you have a couple of sudokus represented as single line texts, like this:

    43.8...29..27....1....2............3..45.28..7............9....2....76..19...5.78
    .....6....59.....82....8....45........3........6..3.54...325..6..................

You will have to set the *empty character* option to `.`, and the delimiter option
to `\n` - the regular expression for newline.

## File input

The file input adheres to the same rules as the text input, it just takes a text
file instead. The same options work the same way.

## The solution

If the application has found a solution for your sudoku or sudokus, it will display
the solution, along with the time it took to solve. It will also color code the
cells by if they were solved by the algorithm, or given.

From here, you can either click `Back` to go back to the input screen (with the
sudoku still in edit mode) or `Clear` to solve a new sudoku (discards the current
sudoku):
