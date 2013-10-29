# Solving algorithms used

Here I try to explain in plain english how the algorithms work.

## Norvig

This is a PHP implementation of Peter Norvigs [sudoku solving algorithm](http://norvig.com/sudoku.html),
all credits here goes to him - I just wrote the PHP code.

This is a recursive backtracking algorithm. It works like this:

- Start at the beginning of the sudoku
- For this cell, try to insert a valid number
- Keep inserting valid numbers until you can not enter any more
    - If this is the last square - great! The sudoku is solved
    - Empty the square and return false, this causes it to bump up one level in the
        call stack, and try the next number.

This is a so called "depth-first" algorithm, which means it will try to solve
the sudoku as far as possible for every number it tests.

It is a beautifully simple algorithm, and it does short work of easy and medium
level puzzles. However, on the hard ones, the nature of the algorithm causes
it to check faulty solutions very deeply before moving on, which makes the
harder puzzles very slow to solve.

## AI

This is my own solver. I wanted to get all puzzles below 1 second, so I wrote my
own, a bit more advanced algorithm.

This makes a bit more decisions, and not as much brute forcing. It still has
backtracking, but as a fallback that very rarely gets used. On most puzzles,
it will never try a faulty number.

This algorithm has 3 levels of complexity, and always tries to use the lower
and faster methods. When they are not enough, it continues on with the more advanced
steps. When these steps have made a step in the right direction, it falls down
to the lower complexities again to not waste resources.

Here are the layers.

1. Fill all cells that only have one possible solution.
2. Check every unit for an option that only occurs once, and insert it
3. Shallow backtracking, try to insert an option in a cell with the fewest possible options,
    and fall down to the lower levels. If it ends up in level 3 again, revert it and try another.
