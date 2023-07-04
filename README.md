### Invoicing API

### Setup Instructions

**Step 1:** Clone the repository in your terminal using the link `https://github.com/victorive/invoicing-api.git`

**Step 2:** Enter the project’s directory using `cd invoicing-api`

**Step 3:** Run `composer install` to install the project’s dependencies.

**Step 4:** Run `cp .env.example .env` to create the .env file for the project’s configuration
and `cp .env.example .env.testing` to create the .env file for the testing environment.

**Step 5:** Run `php artisan key:generate` to set the application key.

**Step 6:** Create a database with the name **invoicing_api** or any name of your choice in your current database
server and configure the DB_DATABASE, DB_USERNAME and DB_PASSWORD credentials respectively, in the .env files located in
the project’s root folder. eg.

> DB_DATABASE={{your database name}}
>
> DB_USERNAME= {{your database username}}
>
> DB_PASSWORD= {{your database password}}

**Step 7:** Run `php artisan migrate` to create your database tables.

**Step 8:** Run `php artisan serve` to serve your application, then use the link generated to access the API via any
API testing software of your choice.

**Step 9:** To run the test suites, make sure you have configured the testing environment using the `.env.testing` file
generated earlier, then run `php artisan test` to test.


#### :WIP


