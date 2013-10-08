<?php

namespace SudokuSolver\Model;

/**
 * Methods for effectively working with a 9x9 array.
 */
abstract class SudokuGrid
{
    protected $sudoku;

    /**
     * @param array $sudoku 2-dimensional 9x9 array
     */
    public function __construct(array $sudoku)
    {
        $this->sudoku = $sudoku;
    }

    /**
     * @param  int $row
     * @param  int $col
     * @return mixed whatever is on that square
     */
    public function getSquare($row, $col)
    {
        return $this->sudoku[$row][$col];
    }

    /**
     * @param  int $row index
     * @return array of all elements on row
     */
    public function getRowContents($index)
    {
        return $this->sudoku[$index];
    }

    /**
     * @param  int $col index
     * @return array of all elements on column
     */
    public function getColumnContents($col)
    {
        return array_column($this->sudoku, $col);
    }

    /**
     * Get contents of a rectangular selection
     * @param  int $top
     * @param  int $left
     * @param  int $bottom
     * @param  int $right
     * @return array flat array of all the elements in the rectangle
     */
    public function getRectangleContents($top, $left, $bottom, $right)
    {
        $rectangle = array();

        // Extract contents of rectangle
        for ($row = $top; $row < $bottom; $row++) {
            for ($col = $left; $col < $right; $col++) {
                $rectangle[] = $this->sudoku[$row][$col];
            }
        }

        return $rectangle;
    }
}
