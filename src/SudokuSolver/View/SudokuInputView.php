<?php

namespace SudokuSolver\View;

use SudokuSolver\View\Template;
use SudokuSolver\View\SudokuInputOptionsView;
use SudokuSolver\View\SudokuInputViewInterface;

/**
 * Renders the main input-section and the sidebar
 */
abstract class SudokuInputView
{
    /**
     * Name of hidden field
     * @var string
     */
    private static $isSubmitted = "_isSubmitted";

    public function __construct()
    {
        // NOTE: Might want to lazy load templates if they are not always used
        $this->template = Template::getTemplate('sudokuInputLayout');
    }

    /**
     * Renders the sudoku-part of the form
     * @return string HTML
     */
    abstract protected function renderSudokuInput();


    // abstract public function isSudokuSubmitted();
    abstract public function getSudoku();

    /**
     * @return string HTML
     */
    public function render()
    {
        // TODO: Assert that __construct has been called

        // NOTE: Submit to self
        return $this->template->render(
            array(
                'action' => '',
                'input' => $this->renderSudokuInput(),
                'isSubmitted' => self::$isSubmitted
            ), true
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

    // TODO: getAlgorithm, getInputMethod
}
