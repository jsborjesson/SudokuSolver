# Use cases

## UC0: Solve a sudoku

### Precondition

- The system has received a sudoku and has been requested to solve it

### Scenario

- The system solves the sudoku, and presents the solution along with the time
it took the algorithm to find the solution to the user.

### Alternate scenarios

- The received sudoku was not a valid sudoku. The system presents an error message
and lets the user fix her mistake before trying again.

- The system was not able to solve the sudoku. The system presents an error message.

## UC1: Solve a sudoku by manual input

### Precondition

- User has a valid sudoku (from a magazine, puzzle book etc)

### Scenario

1. User chooses to enter a sudoku manually.
2. User is presented a empty grid to fill in.
3. User fills in a digit
4. Repeat step `3` until the sudoku is fully entered.
5. `UC0`

## UC2: Solve a sudoku from a string

### Precondition

-   User has a sudoku in form of text.

    It can be a simple string of numbers:

        003020600900305001001806400008102900700000008006708200002609500800203009005010300

    Or with advanced formatting:

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

### Scenario

1. User enters or pastes in the sudoku as text and lets the system try to solve it.
2. `UC0`

### Alternate scenarios

1a. The system presents an error saying that the entered text was not able to
be parsed as a valid sudoku.

## UC3: Solve multiple sudoku from a textfile

### Precondition

-   User has a textfile with one or more sudokus of the format described in UC2

### Scenario

1. User uploads the textfile to the system.
2. User is presented with a list of solutions according to `UC0`.
