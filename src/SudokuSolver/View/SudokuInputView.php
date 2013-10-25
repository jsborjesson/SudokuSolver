<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\View\SudokuInputTypeView;
use SudokuSolver\View\SudokuInputViewInterface;

/**
 * Renders the main input-section and the sidebar
 */
abstract class SudokuInputView
{
    /**
     * Names of input fields
     * @var string
     */
    private static $isSubmitted = "_isSubmitted";
    private static $algorithmName = "algorithm";

    /**
     * @var SudokuInputTypeView
     */
    private $inputTypeView;

    // NOTE: Must be called in subclasses: parent::__contstruct();
    public function __construct()
    {
        // NOTE: Might want to lazy load templates if they are not always used
        $this->template = Template::getTemplate('sudokuInputLayout');

        $this->inputTypeView = new SudokuInputTypeView();
    }

    /**
     * Renders the sudoku-part of the form
     * @return string HTML
     */
    abstract protected function renderSudokuInput();

    /**
     * Returns the sudoku provided by the user
     * @return Sudoku
     */
    abstract public function getSudoku();

    /**
     * @return string HTML
     */
    public function render()
    {
        return $this->template->render(
            array(
                'action' => '', // Submit to self
                'input' => $this->renderSudokuInput(),
                'inputType' => $this->inputTypeView->render(),
                'isSubmitted' => self::$isSubmitted,
                'algorithmName' => self::$algorithmName
            )
        );
    }

    /**
     * If the form has been submitted
     * @return bool
     */
    public function isSubmitted()
    {
        return isset($_POST[self::$isSubmitted]);
    }

    public function getAlgorithm()
    {
        return $_POST[self::$algorithmName];
    }
}
