## Installation Instructions
## Project Dependency
   ```bash
    PHP 7.4.33
    mysql Ver 8.0.39
    node v12.22.9
   ```
1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd <repo-directory>
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Create `.env` file and configure the database.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Run the application:
   ```bash
   php artisan serve
   ```

6. Visit `http://127.0.0.1:8000` to access the application.
