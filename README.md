# Web App - Route for Beers(PHP)

App process data and finds best(semi-best) route for selecting as many beer types as possible.(not optimized)

## Installation

Use the documentation for [laravel](https://laravel.com/docs/5.8/installation) to install it. Runs well of XAMPP. You will need [database from](https://github.com/brewdega/open-beer-database-dumps)(Used MySql,database, name - "beers")


## Usage/Explanation

```
/public 
Gets you to GUI for entering latitude and longitude.
(TextFields only accepts decimal(9,6) which is a format for latitude and longitude).

After button search is pressed. Program reads all the necessary data from database,
forms dataStructures and starts algorithm.

Algorithm is in Route.php class

Algorithm goes through all breweries,checks if brewery beers
are already selected from previous breweries and returns array of: 
Visited breweries, Beer types, distance traveled.

Algorithm is repeated with all possible first choice breweries 
from starting point.

After all choices are checked the final selected beer type array is returned to view.



```

## Tool Used
Visual Studio Code, Laravel, Github, XAMPP. 
