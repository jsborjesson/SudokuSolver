<?php
use Codeception\Util\Stub;
use SudokuSolver\Model\Sudoku;

class SudokuTest extends \Codeception\TestCase\Test
{
    /**
     * @var \CodeGuy
     */
    protected $codeGuy;

    protected function _before()
    {
        // Create test-sudoku
        $this->sudoku = new Sudoku(
            array(
                array(7, 2, 3, 0, 0, 0, 1, 5, 9),
                array(6, 0, 0, 3, 0, 2, 0, 0, 8),
                array(8, 0, 0, 0, 1, 0, 0, 0, 2),
                array(0, 7, 0, 6, 5, 4, 0, 2, 0),
                array(0, 0, 4, 2, 0, 7, 3, 0, 0),
                array(0, 5, 0, 9, 3, 1, 0, 4, 0),
                array(5, 0, 0, 0, 7, 0, 0, 0, 3),
                array(4, 0, 0, 1, 0, 3, 0, 0, 6),
                array(9, 3, 2, 0, 0, 0, 7, 1, 4)
            )
        );
    }

    // tests
    public function testGetRow()
    {
        $this->assertEquals(array(7,2,3,0,0,0,1,5,9), $this->sudoku->getRow(0));
        $this->assertEquals(array(9,3,2,0,0,0,7,1,4), $this->sudoku->getRow(8));
    }

    public function testGetColumn()
    {
        $this->assertEquals(array(7,6,8,0,0,0,5,4,9), $this->sudoku->getColumn(0));
        $this->assertEquals(array(9,8,2,0,0,0,3,6,4), $this->sudoku->getColumn(8));
    }

    public function testGetGroup()
    {
        // top left
        $this->assertEquals(array(7,2,3,6,0,0,8,0,0), $this->sudoku->getGroup(0, 0));

        // middle
        $middle = array(6,5,4,2,0,7,9,3,1);

        // Both of these should give the middle group
        $this->assertEquals($middle, $this->sudoku->getGroup(4, 4));
        $this->assertEquals($middle, $this->sudoku->getGroup(3, 5));
    }

    public function testIsFilled()
    {
        $this->assertFalse($this->sudoku->isFilled(0, 5));
        $this->assertFalse($this->sudoku->isFilled(5, 0));
        $this->assertTrue($this->sudoku->isFilled(0, 0));
        $this->assertTrue($this->sudoku->isFilled(8, 8));
    }
}
