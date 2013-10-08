<?php

namespace SudokuSolver\Model;

/**
 * Contains methods for effectively working with a
 * 2-dimensional array.
 */
class Grid
{
    protected $grid;

    /**
     * @param array $grid 2-dimensional grid
     */
    public function __construct($grid)
    {
        $this->grid = $grid;
    }

    /**
     * @param  int $row
     * @param  int $col
     * @return mixed whatever is on that square
     */
    public function getSquare($row, $col)
    {
        return $this->grid[$row][$col];
    }

    /**
     * @param  int $row index
     * @return array of all elements on row
     */
    public function getRowContents($index)
    {
        return $this->grid[$index];
    }

    /**
     * @param  int $col index
     * @return array of all elements on column
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
    public function getRectangleContents($top, $left, $bottom, $right)
    {
        // TODO: Check for index out of bounds

        $rectangle = array();

        // Extract contents of rectangle
        for ($row = $top; $row < $bottom; $row++) {
            for ($col = $left; $col < $right; $col++) {
                $rectangle[] = $this->grid[$row][$col];
            }
        }

        return $rectangle;
    }
}
