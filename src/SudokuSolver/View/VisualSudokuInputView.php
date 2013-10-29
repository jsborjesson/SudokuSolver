<?php

namespace SudokuSolver\View;

use SudokuSolver\Model\Sudoku;
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
        // FIXME: Very subtle string dependency in concatenating the name
        return $this->cellTpl->render(array('name' => $row . $col));
    }

    // ------ From SudokuInputView ------

    /**
     * @return string HTML
     */
    public function renderSudokuInput()
    {
        return $this->gridHelper->render(function ($row, $col) {
            return $this->cellTpl->render(
                array(
                    'name' => $row . $col,
                    'value' => $this->getCellInput($row, $col)
                )
            );
        });
    }


    /**
     * From SudokuInputView
     * @return Sudoku
     */
    public function getSudoku()
    {
        $arr = array();

        // Collect all inputs
        for ($row = 0; $row < 9; $row++) {
            $arr[$row] = array();
            for ($col = 0; $col < 9; $col++) {
                $arr[$row][$col] = $this->getCellInputDigit($row, $col);
            }
        }

        return new Sudoku($arr);
    }

    // ------ Helpers ------

    /**
     * Get exact input of the input cell
     * @param  int $row
     * @param  int $col
     * @return string
     */
    private function getCellInput($row, $col)
    {
        // TODO: Validation
        if (isset($_POST[$row . $col])) {
            return $_POST[$row . $col];
        }
    }

    /**
     * Same as getCellInput, but always returns a valid digit.
     * If a valid digit is not entered, 0 is returned.
     * @param  int $row
     * @param  int $col
     * @return int      0-9
     */
    private function getCellInputDigit($row, $col)
    {
        $input = $this->getCellInput($row, $col);
        return preg_match('/^[1-9]$/', $input) ? intval($input) : 0;
    }
}
