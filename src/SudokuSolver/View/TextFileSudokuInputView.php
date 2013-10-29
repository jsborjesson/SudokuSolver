<?php

namespace SudokuSolver\View;

use SudokuSolver\View\TextSudokuInputView;
use SudokuSolver\View\Template;
use Exception;

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
     * @throws Exception If file error, or not a text file
     */
    public function getTextInput()
    {
        // Check if file was uploaded
        if (! is_uploaded_file($_FILES[self::$fileInputName]['tmp_name'])) {
            throw new Exception('No file was uploaded');
        }
        // TODO: What does this even do?
        if ($_FILES[self::$fileInputName]['error'] > 0) {
            throw new Exception('Invalid file');
        }
        if ($_FILES[self::$fileInputName]['type'] !== 'text/plain') {
            throw new Exception('Must be a textfile');
        }
        return file_get_contents($_FILES[self::$fileInputName]['tmp_name']);
    }

    /**
     * @return string HTML
     */
    public function renderTextInput()
    {
        return $this->template->render(array('sudokuFile' => self:: $fileInputName));
    }
}
