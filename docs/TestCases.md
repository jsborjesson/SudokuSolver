# Manual tests

Steps to perform tests are written as ordered lists. Expected results are
written in plain text directly after. Tests are to be considered passed if
the system shows an appropriate result, even if the phrasing differs
the expected results here.

## Requirements

- Solving a sudoku should always take less than a second.

## Testcase 1.1: Navigate to page

1. Navigate to the page

You should see the title, sidebar and a sudoku input

### TC1.2 Clear sudoku

Should be applied to all input-types

1. Input anything in sudoku
2. Click clear
3. Confirm that you want to clear

Same input type but without content is shown

### TC1.3 Return from solution

Precondition: Viewing successful solution

1. Click clear/return
2. You should be asked to confirm
3. Confirm

Same input type but without content is shown


## Testcases 2: Visual input

Precondition: Visual input screen active

### TC2.1: No input

1. Submit an empty sudoku

"Must enter a sudoku"

### TC2.2: Invalid input

1. Turn off JS
2. Enter letters

"Invalid input"

### TC2.3: Invalid sudoku

1. Enter a sudoku with duplicate digits in a region

"Invalid sudoku"

### TC2.4: Solve sudoku

1. Enter valid sudoku
2. Click Solve!

You see:

- Solution
- Time it took to solve
- Algorithm used

## Testcases 3: Text input

Precondition: Text input screen active

### TC3.1: No input

1. Click solve

"No sudoku has been sent"

### TC3.2: Test valid sudokus

1. Solve one line sudoku
2. Solve multiline sudoku
3. Solve multiline sudoku with dots as zero-char
4. Solve multiple sudokus at once

All of these should work fine

### TC3.3: Test invalid string

1. Enter invalid sudoku string

"Invalid sudoku", the string is still there
