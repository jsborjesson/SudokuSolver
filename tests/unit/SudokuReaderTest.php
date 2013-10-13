<?php
use Codeception\Util\Stub;
use SudokuSolver\Model\SudokuReader;
use SudokuSolver\Model\Sudoku;

class SudokuReaderTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests

    public function testValidSingleRowNumbers()
    {
        $str = '003020600900305001001806400008102900700000008006708200002609500800203009005010300';
        SudokuReader::fromString($str);
    }

    public function testValidNumbersAndNewlines()
    {
        $str = '
            400000805
            030000000
            000700000
            020000060
            000080400
            000010000
            000603070
            500200000
            104000000
        ';
        SudokuReader::fromString($str);
    }

    public function testValidSingleRowWithDots()
    {
        $str = '.....6....59.....82....8....45........3........6..3.54...325..6..................';
        SudokuReader::fromString($str, '.');
    }

    public function testValidGraphicGridWithDots()
    {
        $str = '
            7 2 3 | . . . | 1 5 9
            6 . . | 3 . 2 | . . 8
            8 . . | . 1 . | . . 2
            - - -   - - -   - - -
            . 7 . | 6 5 4 | . 2 .
            . . 4 | 2 . 7 | 3 . .
            . 5 . | 9 3 1 | . 4 .
            - - -   - - -   - - -
            5 . . | . 7 . | . . 3
            4 . . | 1 . 3 | . . 6
            9 3 2 | . . . | 7 1 4
        ';
        SudokuReader::fromString($str, '.');
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidString()
    {
        // TODO
    }

}
