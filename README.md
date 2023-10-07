# Installation Guide for Laravel Point of Sale (POS) System

Follow these steps to set up and run the Laravel POS System on your local development environment.

Prerequisites
Before you begin, ensure you have the following prerequisites installed:

1. PHP (recommended version)
2. Composer
3. MySQL or another compatible database
4. Web server (e.g., Apache, Nginx)
5. Installation Steps
6. Clone the Repository

Clone the Laravel POS System repository to your local machine:

```sh
git clone https://github.com/Mohamedhani222/pos-system.git
```

# Install Dependencies

Navigate to the project directory and install the PHP dependencies using Composer:

```sh
cd cashier_system
composer install
```
### Configure Environment Variables

Create a copy of the .env.example file and name it .env. Update the configuration settings such as the database connection details and application key:

```sh
cp .env.example .env
```

Then, generate a unique application key:

```sh
php artisan key:generate
```

Database Setup

Create a new database for your Laravel POS System and update the .env file with the database credentials.

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

Next, run the database migrations and seed the initial data:

```sh
php artisan migrate --seed
```

Start the Development Server

Run the development server using Artisan:

```sh
php artisan serve
```
The POS system should now be accessible at http://localhost:8000 in your web browser.





