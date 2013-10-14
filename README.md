# SudokuSolver

Should eventually solve sudoku puzzles.

## Standards

- HTML5
- [PHP-FIG](www.php-fig.org)

## Goals

- Make a complete project from design to deployment
- Learn more about design patterns and OOP
- Learn to use git more effectively, dev branch etc
- Maintain a well documented and high quality code-base
- To learn about and use automated testing

## Filestructure

- `index.php`: entry point for application
- `codeception.yml`: configuration for automatic tests
- `config.rb`: configuration for css-framework, makes `compass compile` work
- `composer.json`: dependency declaration: makes `composer install` work
- `public/`: contains styles and templates
- `docs/`: documentation for the project
- `src/`: the php source code
- `tests/` automatic tests

## Installing

The tools needed to get this running are [Composer](http://getcomposer.org/) and [Ruby](https://www.ruby-lang.org/).
They have their own installation instructions.

Unless you're running a [very bad operating system](http://windows.microsoft.com/en-us/windows/home),
it should only require a couple of lines in the terminal to get everything running.

### Composer

If you have installed Composer locally, you will need to replace
`composer` with `php composer.phar`.

To install the projects dependancies:

    composer install


### Styles

I use Gumby framework for styles. It has a couple of dependencies. To generate
the CSS-files required for the live site:

    # Make sure the dependancies are installed
    gem install compass modular-scale sass

    # Compile the css
    compass compile


## Testing

    # Make sure Codeception is installed
    composer install --dev

Note: if you do not have `codecept` in your path, it is located in the vendor/bin directory.

    # Generate testing files
    codecept build

    # Run the unit tests
    codecept run unit

## Credits

Huge thanks to Peter Norvig for writing the [great article](http://norvig.com/sudoku.html)
that helped make the solving algorithm a thousand times better.
