<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Sudoku;
use SudokuSolver\View\Template;

class SudokuView
{

    private $sudoku;

    /**
     * @param Sudoku $sudoku
     */
    public function __construct(Sudoku $sudoku)
    {
        $this->sudoku = $sudoku;
    }

    public function render()
    {
        $html = '';

        // TODO: Break out html
        for ($row = 0; $row < 9; $row++) {
            $html .= "<div>";
            for ($col = 0; $col < 9; $col++) {
                $value = $this->sudoku->getCell($row, $col);
                $html .= "<span>$value</span>";
            }
            $html .= "</div>";
        }

        return $html;
    }
}
