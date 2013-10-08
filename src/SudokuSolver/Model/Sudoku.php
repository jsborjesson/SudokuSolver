<?php

namespace SudokuSolver\Model;

/**
 * Holds a sudoku and accessor methods
 */
class Sudoku extends SudokuGrid
{
    /**
     * @var int[][]
     */
    protected $sudoku;

    public function __construct(array $sudoku)
    {
        // TODO: Validate
        $this->sudoku = $sudoku;
    }

    public function isValid()
    {
        // TODO: Implement validation
    }

    /**
     * @param  int $row
     * @param  int $col
     * @return int the number on that square
     */
    public function getSquare($row, $col)
    {
        return $this->grid[$row][$col];
    }

    /**
     * @param  int $row index
     * @return array of all numbers in row
     */
    public function getRowContents($index)
    {
        return $this->grid[$index];
    }

    /**
     * @param  int $col index
     * @return array of all numbers in column
     */
    public function getColumnContents($col)
    {
        return array_column($this->grid, $col);
    }

    /**
     * Get contents of a rectangular selection
     * @param  int $top
     * @param  int $left
     * @param  int $bottom
     * @param  int $right
     * @return array flat array of all the elements in the rectangle
     */
    private function getRectangleContents($top, $left, $bottom, $right)
    {
        $rectangle = array();

        // Extract contents of rectangle
        for ($row = $top; $row < $bottom; $row++) {
            for ($col = $left; $col < $right; $col++) {
                $rectangle[] = $this->grid[$row][$col];
            }
        }

        return $rectangle;
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

        // Use them as rectangular
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
