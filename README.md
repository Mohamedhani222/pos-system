Installation Guide for Laravel Point of Sale (POS) System
Follow these steps to set up and run the Laravel POS System on your local development environment.

Prerequisites
Before you begin, ensure you have the following prerequisites installed:

PHP (recommended version)
Composer
MySQL or another compatible database
Web server (e.g., Apache, Nginx)
Installation Steps
Clone the Repository

Clone the Laravel POS System repository to your local machine:


git clone https://github.com/Mohamedhani222/pos-system.git
Install Dependencies

Navigate to the project directory and install the PHP dependencies using Composer:


cd cashier_system
composer install
Configure Environment Variables

Create a copy of the .env.example file and name it .env. Update the configuration settings such as the database connection details and application key:


cp .env.example .env
Then, generate a unique application key:


php artisan key:generate
Database Setup

Create a new database for your Laravel POS System and update the .env file with the database credentials.


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
Next, run the database migrations and seed the initial data:


php artisan migrate --seed
Start the Development Server

Run the development server using Artisan:


php artisan serve
The POS system should now be accessible at http://localhost:8000 in your web browser.

Login to the System

Access the system in your web browser and log in using the default credentials (if provided) or create a new account.

Configuration

Configure the system according to your business requirements, including adding products, setting up tax rates, and customizing the point of sale settings.

Additional Information
For more detailed information on using and customizing the Laravel POS System, refer to the documentation or visit our GitHub repository for the latest updates and contributions.

Be sure to replace the placeholders with actual links to your documentation and GitHub repository. These steps provide a clear and concise guide for users to install and set up your Laravel POS System on their local development environment.




