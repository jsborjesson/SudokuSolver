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
        // Create valid test-sudoku used in many tests
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

    public function testGetContainingGroup()
    {
        // top left
        $this->assertEquals(array(7,2,3,6,0,0,8,0,0), $this->sudoku->getContainingGroup(0, 0));

        // middle
        $middle = array(6,5,4,2,0,7,9,3,1);

        // Both of these should give the middle group
        $this->assertEquals($middle, $this->sudoku->getContainingGroup(4, 4));
        $this->assertEquals($middle, $this->sudoku->getContainingGroup(3, 5));
    }

    public function testGetGroupByIndex()
    {
        // top left
        $this->assertEquals(array(7,2,3,6,0,0,8,0,0), $this->sudoku->getGroupByIndex(0));

        // middle
        $this->assertEquals(array(6,5,4,2,0,7,9,3,1), $this->sudoku->getGroupByIndex(4));

        // bottom left
        $this->assertEquals(array(5,0,0,4,0,0,9,3,2), $this->sudoku->getGroupByIndex(6));
    }

    public function testIsFilled()
    {
        $this->assertFalse($this->sudoku->isFilled(0, 5));
        $this->assertFalse($this->sudoku->isFilled(5, 0));
        $this->assertTrue($this->sudoku->isFilled(0, 0));
        $this->assertTrue($this->sudoku->isFilled(8, 8));
    }

    public function testValidateValidSudoku()
    {
        // The testing sudoku is valid and should not throw
        $this->sudoku->validate();
    }

    /**
     * @expectedException         Exception
     * @expectedExceptionMessage  Sudoku must be exactly 9x9 cells
     */
    public function testValidateNonSquareSudoku()
    {
        // Has invalid cell value
        $inValidSudoku = new Sudoku(
            array(
                array(7, 2, 3, 0, 0, 5, 1, 5, 9),
                array(6, 0, 0, 3, 0, 2, 0, 0, 8),
                array(8, 0, 0, 0, 1, 0, 0, 0, 2),
                array(0, 7, 0, 6, -5, 4, 0, 2, 0),
                array(0, 0, 4, 2, 0, 7, 3, 0), // This row is too short!
                array(0, 5, 0, 9, 3, 1, 0, 4, 0),
                array(5, 0, 0, 0, 7, 0, 0, 0, 3),
                array(4, 0, 0, 1, 0, 3, 0, 0, 6),
                array(9, 3, 2, 0, 0, 0, 7, 1, 4)
            )
        );
        $inValidSudoku->validate();
    }

    /**
     * @expectedException         Exception
     * @expectedExceptionMessage  Invalid cell value
     */
    public function testValidateWithInvalidCell()
    {
        // Has invalid cell value
        $inValidSudoku = new Sudoku(
            array(
                array(7, 2, 3, 0, 0, 5, 1, 5, 9),
                array(6, 0, 0, 3, 0, 2, 0, 0, 8),
                array(8, 0, 0, 0, 1, 0, 0, 0, 2),
                array(0, 7, 0, 6, -5, 4, 0, 2, 0),
                array(0, 0, 4, 2, 0, 7, 3, 0, 0),
                array(0, 5, 0, 9, 3, 1, 0, 4, 0),
                array(5, 0, 0, 0, 7, 0, 0, 0, 3),
                array(4, 0, 0, 1, 0, 3, 0, 0, 6),
                array(9, 3, 2, 0, 0, 0, 7, 1, 4)
            )
        );
        $inValidSudoku->validate();
    }

    /**
     * @expectedException         Exception
     * @expectedExceptionMessage  Duplicate value in row 0
     */
    public function testValidateWithDuplicatedCell()
    {
        // Has duplicated digits in row 1
        $inValidSudoku = new Sudoku(
            array(
                array(7, 2, 3, 0, 0, 5, 1, 5, 9),
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
        $inValidSudoku->validate();
    }

    public function testIsSolved()
    {
        // No
        $this->assertFalse($this->sudoku->isSolved());

        // Yes
        $solvedSudoku = new Sudoku(
            array(
                array(7, 2, 3, 8, 4, 6, 1, 5, 9),
                array(6, 1, 5, 3, 9, 2, 4, 7, 8),
                array(8, 4, 9, 7, 1, 5, 6, 3, 2),
                array(3, 7, 8, 6, 5, 4, 9, 2, 1),
                array(1, 9, 4, 2, 8, 7, 3, 6, 5),
                array(2, 5, 6, 9, 3, 1, 8, 4, 7),
                array(5, 6, 1, 4, 7, 9, 2, 8, 3),
                array(4, 8, 7, 1, 2, 3, 5, 9, 6),
                array(9, 3, 2, 5, 6, 8, 7, 1, 4)
            )
        );
        $this->assertTrue($solvedSudoku->isSolved());
    }

    public function testClone()
    {
        // Make sure the clone does not reference the same array

        // Create clone
        $clone = clone($this->sudoku);

        // Make sure they are the same
        $this->assertEquals($clone->getRow(8), $this->sudoku->getRow(8));

        // Change a cell
        $clone->setCell(8, 0, 6); // 9 -> 6

        // Make sure both have not changed
        $this->assertNotEquals($clone->getRow(8), $this->sudoku->getRow(8));
    }
}
