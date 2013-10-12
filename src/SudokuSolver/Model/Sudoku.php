<?php

namespace SudokuSolver\Model;

/**
 * Holds a sudoku and manages possible answers in cells
 */
class Sudoku
{
    private static $size = 9;


    /**
     * Holds the sudoku
     * @var array 2-dimensional 9x9 array of integers
     */
    private $sudoku = array();

    public function __construct($grid)
    {
        // TODO: Lots of validation
        $this->sudoku = $grid;
    }


    /**
     * Array of values in column
     * @param  int $col
     * @return int[]
     */
    public function getColumn($col)
    {
        return array_column($this->sudoku, $col);
    }

    /**
     * Array of values in row
     * @param  int $row
     * @return int[]
     */
    public function getRow($row)
    {
        return $this->sudoku[$row];
    }

    /**
     * Flat array of values in 3x3 section
     * @param  int $row any row in group
     * @param  int $col any column in group
     * @return int[]
     */
    public function getGroup($row, $col)
    {
        // Find out which group the coordinates belong to
        $groupRow = floor($row/ 3) * 3;
        $groupCol = floor($col / 3) * 3;

        $values = array();

        // Collect the values
        for ($rowIx = $groupRow; $rowIx < $groupRow + 3; $rowIx++) {
            for ($colIx = $groupCol; $colIx < $groupCol + 3; $colIx++) {
                $values[] = $this->sudoku[$rowIx][$colIx];
            }
        }

        return $values;
    }

    /**
     * Useful for debugging
     * @return string
     */
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
