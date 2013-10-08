<?php

namespace SudokuSolver\Model;

/**
 * Holds a sudoku and accessor methods
 */
class Sudoku extends Grid
{
    public function __construct($grid)
    {
        parent::__construct($grid);
    }

    /**
     * Get all numbers in the containing group
     * @param  int $row index
     * @param  int $col index
     * @return array of digits
     */
    public function getGroupContents($row, $col)
    {
        // Calculate coordinates
        $top = floor($row/ 3) * 3;
        $left = floor($col / 3) * 3;
        $bottom = $top + 3;
        $right = $left + 3;

        return $this->getRectangleContents($top, $left, $bottom, $right);
    }

    /**
     * Useful for console debugging
     * @return string visualization of grid
     */
    public function __toString()
    {
        $str = " -------------------\n";
        for ($row = 0; $row < 9; $row++) {
            $str .= '| ';
            for ($col = 0; $col < 9; $col++) {
                $str .= $this->grid[$row][$col] . ' ';
            }
            $str .= "|\n";
        }
        $str .= " -------------------\n";
        return $str;
    }
}
