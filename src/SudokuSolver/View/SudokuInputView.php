<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\View\SudokuInputTypeView;
use SudokuSolver\View\SudokuInputViewInterface;
use Exception;

/**
 * Renders the main input-section and the sidebar
 */
abstract class SudokuInputView
{
    const SOLVER_AI = 1;
    const SOLVER_NORVIG = 2;

    /**
     * Names of input fields
     * @var string
     */
    private static $isSubmitted = "_isSubmitted";
    private static $algorithmName = "algorithm";

    /**
     * @var Template
     */
    private $template;

    /**
     * @var SudokuInputTypeView
     */
    private $inputTypeView;

    // NOTE: Must be called in subclasses: parent::__contstruct();
    protected function __construct()
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
     * Get the input sudoku
     * @return Sudoku
     */
    abstract public function getSudoku();

    /**
     * @return string HTML
     */
    public function render($errorMessage = '')
    {
        return $this->template->render(
            array(
                'action' => '', // Submit to self
                'input' => $this->renderSudokuInput(),
                'inputType' => $this->inputTypeView->render(),
                'isSubmitted' => self::$isSubmitted,
                'algorithmName' => self::$algorithmName,
                'errorMessage' => $errorMessage
            )

        );
    }

    /**
     * Shows an error message along with the input
     * @param  Exception $e
     * @return string HTML
     */
    public function renderError(Exception $e)
    {
        // NOTE: Custom exception types could be handled here, to provide more custom error messages
        return $this->render($e->getMessage());
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
        // NOTE: Should be one of the constants, robust _enough_ for now
        return intval($_POST[self::$algorithmName]);
    }
}
