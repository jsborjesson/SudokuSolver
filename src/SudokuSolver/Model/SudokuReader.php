<?php
/**
 * Provides functions for creating Sudoku-objects from strings and files
 */

namespace SudokuSolver\Model;

use SudokuSolver\Model\Sudoku;
use Exception;

class SudokuReader
{
    /**
     * Construct a sudoku object from a string.
     *
     * Zeros are empty cells, but you can also use dots or similar using
     * the $zeroChar argument (0 will still also be a valid empty cell).
     *
     * All other characters will be ignored. This means that all of these
     * are perfectly valid sudoku strings:
     *
     *
     *     003020600900305001001806400008102900700000008006708200002609500800203009005010300
     *
     *     400000805
     *     030000000
     *     000700000
     *     020000060
     *     000080400
     *     000010000
     *     000603070
     *     500200000
     *     104000000
     *
     * These will need to be run with $zeroChar = '.'
     *
     *     .....6....59.....82....8....45........3........6..3.54...325..6..................
     *
     *     7 2 3 | . . . | 1 5 9
     *     6 . . | 3 . 2 | . . 8
     *     8 . . | . 1 . | . . 2
     *     - - -   - - -   - - -
     *     . 7 . | 6 5 4 | . 2 .
     *     . . 4 | 2 . 7 | 3 . .
     *     . 5 . | 9 3 1 | . 4 .
     *     - - -   - - -   - - -
     *     5 . . | . 7 . | . . 3
     *     4 . . | 1 . 3 | . . 6
     *     9 3 2 | . . . | 7 1 4
     *
     *
     * @param  string $str
     * @param  string $zeroChar optional representation of empty cell
     * @return Sudoku
     * @throws Exception If invalid string
     */
    public function fromString($str, $zeroChar = '')
    {
        // Convert zeroChars to zeros
        $str = str_replace($zeroChar, '0', $str);

        // Ignore all characters except numbers
        $str = preg_replace('/[^0-9]/', '', $str);

        // Exception if the fixed string is still not the right length
        if (strlen($str) !== 81) {
            throw new Exception('Invalid string');
        }

        // Array of chars
        $arr = str_split($str);

        // Array of ints
        $arr = array_map('intval', $arr);

        // 2-dimensional array
        $grid = array_chunk($arr, 9);

        // Sudoku
        return new Sudoku($grid);
    }
}
