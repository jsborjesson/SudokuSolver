# Manual tests

## Requirements

- Solving a sudoku should always take less than a second.

## Testcase 1.1: Navigate to page

1. Navigate to the page

You should see the title, sidebar and a sudoku input

## TC1.2 Clear sudoku

Should be applied to all input-types

1. Input anything in sudoku
2. Click clear
3. Confirm that you want to clear

Same input type but without content is shown

## TC1.3 Return from solution

Precondition: Viewing successful solution

1. Click clear/return
2. You should be asked to confirm
3. Confirm

Same input type but without content is shown


## Testcases 2: Visual input

Precondition: Visual input screen active

## TC 2.1: No input

1. Submit an empty sudoku

"Must enter a sudoku"

## TC 2.2: Invalid input

1. Turn off JS
2. Enter letters

"Invalid input"

## TC2.3 Invalid sudoku

1. Enter a sudoku with duplicate digits in a region

"Invalid sudoku"

## TC2.4 Solve sudoku

1. Enter valid sudoku
2. Click Solve!

You see:

- Solution
- Time it took to solve
- Algorithm used

