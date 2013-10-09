<?php

namespace SudokuSolver\Model;

/**
 * Methods for effectively working with a 9x9 array.
 */
abstract class SudokuGrid
{
    /**
     * @var array 9x9 array
     */
    protected $sudoku;

    /**
     * @param array $sudoku 2-dimensional 9x9 array
     */
    public function __construct(array $sudoku)
    {
        // TODO: Validate constraints
        $this->sudoku = $sudoku;
    }

    /**
     * @param  int $row
     * @param  int $col
     * @return mixed element on the square
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
     * @return array flat array of elements in rectangle
     */
    private function getRectangleContents($top, $left, $bottom, $right)
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

    /**
     * Get all elements in the containing group
     * @param  int $row index
     * @param  int $col index
     * @return array flat array of elements in group
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

    // TODO: Test forEachSquare
    public function forEachSquare(callable $func)
    {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                $func($this->sudoku[$row][$col], $row, $col);
            }
        }
    }
}
