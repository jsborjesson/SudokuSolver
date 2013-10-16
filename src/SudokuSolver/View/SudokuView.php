<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Sudoku;
use SudokuSolver\View\Template;

class SudokuView
{

    /**
     * @var Sudoku
     */
    private $sudoku;

    /**
     * @param Sudoku $sudoku
     */
    public function __construct(Sudoku $sudoku)
    {
        $this->sudoku = $sudoku;

        $this->cellTemplate = Template::getTemplate('sudoku-cell-static');
        $this->rowTemplate = Template::getTemplate('sudoku-row');
    }

    public function render()
    {
        $html = '';

        // TODO: Break out html
        for ($row = 0; $row < 9; $row++) {
            $html .= $this->getRowHtml($row);
        }

        return $html;
    }

    protected function getRowHtml($row)
    {
        $rowHtml = '';
        foreach ($this->sudoku->getRow($row) as $cell) {
            $rowHtml .= $this->getCellHtml($cell);
        }
        return $this->rowTemplate->render(array('cells' => $rowHtml));
    }

    protected function getCellHtml($digit)
    {
        // Digit or empty
        //$digit = $this->sudoku->isFilled($row, $col) ? $this->sudoku->getCell($row, $col) : '';
        $digit = $digit ? $digit : '';

        $opts = array(
            'class' => '',
            'digit' => $digit
        );
        return $this->cellTemplate->render($opts);
    }


}
