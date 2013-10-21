// TODO: Only include this on form-input page
// TODO: 'Are you sure?' on clear-button
(function () {
    'use strict';

    // Move to next input square when a valid number/nothing is entered,
    // prevent other characters from being entered.
    $('input.sudoku-cell').keypress(function (event) {
        // Get char
        var c = String.fromCharCode(event.which);
        // If digit or space
        if (/[1-9\ ]/.test(c)) {
            // Move to next square
            $(this).next('input.sudoku-cell')[0].focus();
        } else {
            // Don't allow
            return false;
        }
        // TODO: Previous on backspace
    });

    // Make sure the grid stays square

}());
