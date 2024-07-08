
# XML-DB-Import Project Documentation

This repository contains code for importing and managing XML data in a database using Laravel.


### Installation
- Clone the repository:
```http
git clone https://github.com/DelvinNJ/xml-db-import.git
```
```http
cd xml-db-import
```

- Install dependencies using Composer:
```http
composer install
```

- Copy the environment file and generate application key:
```http
cp .env.example .env
```
```http
php artisan key:generate
```
### Database Setup

- Configure the database in .env file.
- Create the SQLite database file: 
```http
touch database/db.sqlite
```

Run database migrations to set up the database schema:
```http
php artisan migrate
```


### Running Unit Tests
To run the unit tests:
```http
php artisan test
```

### XML Operations
#### Store XML Data

To store XML data into the database from a file:
```http
php artisan store-xml-data "file_name"
```
Replace "file_name" with the actual path of your XML file.
```http
php artisan store-xml-data "file_name"
```
#### Update XML Data

To update XML data from a file:
```http
php artisan update-xml-data "file_name"
```
Replace "file_name" with the actual path of your XML file.
```http
php artisan update-xml-data feed.xml
```


### Logging
Logs for XML operations are stored in:
```http
storage/logs/xml_operation.log
```

#### Log Viewer
To view logs, start the Laravel development server:
```http
php artisan serve
```
Then, navigate to the following URL in your web browser:
```http
http://127.0.0.1:8000/log-viewer
```


Contact
If you have any questions or feedback, feel free to reach out:

Email: delvinnj02@gmail.com

Happy coding!