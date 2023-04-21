Davits Test Task
This is a test project for Davits, which involves creating a web application that can read data from a CSV file and display it in a table. To run this project on your machine, follow these steps:

Prerequisites
PHP 7.2 or higher
MySQL 5.7 or higher
Node.js 12.18 or higher
Installation
Clone this repository to your local machine:

bash
git clone https://github.com/datopipo/davits-test-task.git


Update the .env file to connect to your MySQL database:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dataset
DB_USERNAME=[your-username]
DB_PASSWORD=[your-password]

Create a new database called dataset in your MySQL server.

Run the migration command to create the necessary database tables:

php artisan migrate

Place the dataset.csv file into the public directory of the project.

Install the necessary JavaScript packages:
npm install

Run the development server:
npm run dev

Once you've completed these steps, you should be able to view the project by visiting http://localhost:8000 in your web browser.




