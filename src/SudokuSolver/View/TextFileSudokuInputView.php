<?php

namespace SudokuSolver\View;

use SudokuSolver\View\TextSudokuInputView;
use SudokuSolver\View\Template;

// Take advantage of TextSudokuInputView, just a few things to override
class TextFileSudokuInputView extends TextSudokuInputView
{
    /**
     * @var Template
     */
    private $template;

    private static $fileInputName = 'sudokuFile';

    public function __construct()
    {
        parent::__construct();
        $this->template = Template::getTemplate('sudokuTextFileInput');
    }

    /**
     * Get input from file
     * @return string
     */
    public function getTextInput()
    {
        return '';
    }

    /**
     * @return string HTML
     */
    public function renderTextInput()
    {
        return $this->template->render(array('sudokuFile' => self:: $fileInputName));
    }
}
