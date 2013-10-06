<?php

namespace SudokuSolver;

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
        $row = floor($row/ 3) * 3;
        $col = floor($col / 3) * 3;

        // Slice horizontally
        $group = array_slice($this->sudoku, $row, $row + 3);

        // Slice vertically
        foreach ($group as &$row) {
            $row = array_slice($row, $col, $col + 3);
        }

        return $group;
    }
}
