Label Generator
=============

This module uses data stored in a sqlite database and displays in the browser window a pdf label that contains the data,
after validating it.

--------------------------------------------

Installation
------------

```
composer require TarLink/generate-label
```

It requires PHP version 7.1.


Basic Usage
===========

There has to be an Sqlite file, with a table named 'addresses', with the structure

```text
firstname varchar(25)
lastname varchar(25)
company_name varchar(25)
street_address_1 varchar(100)
street_address_2 varchar(100)
city varchar(25)
state varchar(25)
zip varchar(10)
country varchar(25)
phone varchar(15)
email varchar(50)
```

To load and display the label use the following code

```php
use Glfromd\Generator;

$generator = new Generator($path_to_sqlite_file);

$generator->run();
```

It will load a random entry from the database. If the validation fails, a screen
with the errors is displayed

If the validation passes, it will display the pdf label of the selected element, with
the following fields:

```php
Name
Company Name
Full Address
Phone Number
Email
Unique Identifier
```

The unique identifier is a hash of all the fields in the table's row
