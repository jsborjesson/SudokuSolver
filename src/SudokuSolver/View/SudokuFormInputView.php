<?php

namespace SudokuSolver\View;

use SudokuSolver\View\AbstractSudokuView;
use SudokuSolver\View\Template;

/**
 * Displays a sudoku-grid with input elements for a user to manually
 * input a sudoku puzzle.
 */
class SudokuFormInputView extends AbstractSudokuView implements SudokuInputViewInterface
{
    /**
     * @var Template
     */
    private $cellTpl;
    private $rowTpl;
    private $gridTpl;

    /**
     * Name of the hidden field
     * @var string
     */
    private static $isPostback = '_isPostback';

    public function __construct()
    {
        parent::__construct();
        // Set templates
        $this->cellTpl = Template::getTemplate('sudokuCellInput'); // input field
    }

    // NOTE: From AbstractSudokuView
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
