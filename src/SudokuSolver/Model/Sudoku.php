<?php

namespace SudokuSolver\Model;

/**
 * Holds a sudoku and manages possible answers in cells
 */
class Sudoku
{
    const SIZE = 9;

    /**
     * Holds the sudoku
     * @var array 2-dimensional 9x9 array of integers
     */
    private $sudoku = array();

    // TODO: constructor functions
    public static function fromString($string) {}

    public function __construct($grid)
    {
        // TODO: Lots of validation
        $this->sudoku = $grid;
    }

    public function __toString()
    {
        $str = '';
        foreach ($this->sudoku as $rowIx => $row) {
            // Horizontal dividers
            $str .= ($rowIx > 0 && $rowIx % 3 == 0) ? "- - -   - - -   - - -\n" : '';
            foreach ($row as $colIx => $cell) {
                // Vertical dividers
                $str .= ($colIx > 0 && $colIx % 3 == 0) ? '| ' : '';
                // Number or empty space
                $str .= $cell > 0 ? $cell : ' ';
                // Alignment space
                $str .= ' ';
            }
            $str .= "\n";
        }
        return $str;
    }
}
