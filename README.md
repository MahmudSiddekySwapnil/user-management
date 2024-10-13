## Installation Instructions
## Project Dependency
   ```bash
    PHP 7.4.33
    mysql Ver 8.0.39
    node v16.8.0
   ```
1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd <repo-directory>
   ```

2. Install dependencies:
   ```bash
   composer install
   
   npm install
   ```
   
3. Create `.env` file and configure the database.


4. Generate the application encryption key
   ```bash
   php artisan key:generate
   ```
   
5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Run the application:
   ```bash
   php artisan serve
   ```
7. Create storage symbolic link:
 ```bash
    php artisan storage:link
   ```

8. Visit `http://127.0.0.1:8000` to access the application.
