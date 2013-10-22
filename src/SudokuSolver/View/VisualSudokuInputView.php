<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\View\SudokuInputView;
use SudokuSolver\View\SudokuGridHelper;

/**
 * Displays a sudoku-grid with input elements for a user to manually
 * input a sudoku puzzle.
 */
class VisualSudokuInputView extends SudokuInputView
{
    /**
     * @var Template
     */
    private $cellTpl;

    /**
     * @var SudokuGridHelper
     */
    private $gridHelper;

    /**
     * Name of the hidden field
     * @var string
     */
    private static $isPostback = '_isPostback';

    public function __construct()
    {
        parent::__construct();
        $this->cellTpl = Template::getTemplate('sudokuCellInput'); // input field
        $this->gridHelper = new SudokuGridHelper();
    }

    /**
     * Input field for a cell
     * @param  int $row
     * @param  int $col
     * @return string   HTML
     */
    protected function getCellHtml($row, $col)
    {
        // TODO: Persist already filled in numbers
        return $this->cellTpl->render(array('name' => $row . $col));
    }

    public function renderSudokuInput()
    {
        return $this->gridHelper->render(function ($row, $col) {
            return $this->cellTpl->render(array('name' => $row . $col));
        });
    }


    // TODO: Implememnt interface
    public function getSudoku()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Get input cell contents
     * @param  int $row
     * @param  int $col
     * @return int      digit
     */
    private function getCellInput($row, $col)
    {
        // TODO: Validation
        //if (isset($_POST[$row . $col]))
    }
}
