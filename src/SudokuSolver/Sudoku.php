<?php

namespace SudokuSolver;

/**
 * Holds a sudoku and accessor methods
 */
class Sudoku
{
    protected $sudoku;

    public function __construct($sudokuArray)
    {
        $this->sudoku = $sudokuArray;
    }

    /**
     * Get all numbers of row
     * @param  int $row index
     * @return array of digits
     */
    public function getRowContents($index)
    {
        return $this->sudoku[$index];
    }

    /**
     * Get all numbers of column
     * @param  int $col index
     * @return array of digits
     */
    public function getColumnContents($col)
    {
        return array_column($this->sudoku, $col);
    }

    /**
     * Get all numbers in the containing group
     * @param  int $row index
     * @param  int $col index
     * @return array of digits
     */
    public function getGroupContents($row, $col)
    {
        // Get top-left indexes of group
        $top = floor($row/ 3) * 3;
        $left = floor($col / 3) * 3;

        $group = array();

        // Extract contents of group
        for ($row = $top; $row < $top + 3; $row++) {
            for ($col = $left; $col < $left + 3; $col++) {
                $group[] = $this->sudoku[$row][$col];
            }
        }

        return $group;
    }
}
