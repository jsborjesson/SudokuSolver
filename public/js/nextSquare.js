// Move to next input square when a valid number/nothing is entered,
// prevent other characters from being entered.
// TODO: Only include this on form-input page
$('input.sudoku-cell').keypress(function (event) {
    // Get char
    var c = String.fromCharCode(event.which);
    // If digit or space
    if (/[0-9\ ]/.test(c)) {
        // Move to next square
        $(this).next('input.sudoku-cell')[0].focus();
    } else {
        // Clear the input and stay
        return false;
    }

});
