// TODO: Only include this on form-input page
// When char entered in square
$('input.sudoku-cell').on('keyup', function () {
    // Move to next input square
    $(this).next('input.sudoku-cell')[0].focus();
    // TODO: Validate as number
});
