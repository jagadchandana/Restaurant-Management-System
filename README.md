# Restaurant Management System

## Instructions to Run the Project

Follow these steps to set up and run the project:

### Prerequisites
- PHP >= 8.0
- Composer
- MySQL
- Node.js and npm

### Steps

1. **Clone the Repository**

2. **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3. **Set Up Environment**
    - Copy `.env.example` to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the `.env` file with your database credentials.

4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations and Seed Database**
    ```bash
    php artisan migrate --seed
    ```

6. **Build Frontend Assets**
    ```bash
    npm run dev
    ```

7. **Start the Development Server**
    ```bash
    php artisan serve
    ```

8. **Access the Application**
    Open your browser and navigate to `http://127.0.0.1:8000/login`.

### Background Processes

To handle scheduled tasks and queued jobs, use the following commands:

- **Run the Scheduler**
    ```bash
    php artisan schedule:work
    ```

- **Run the Queue Worker**
    ```bash
    php artisan queue:work
    ### Default Login Credentials

### Login credentials

    For testing purposes, you can use the following login credentials:

    - **Manager Staff**
        - Email: `manager@mail.com`
        - Password: `1qaz2wsx`

    - **Kitchen Manager Staff**
        - Email: `kitchen.manager@mail.com`
        - Password: `1qaz2wsx`

### Additional Commands
- To run tests:
  ```bash
  php artisan test
  ```
- To compile assets for production:
  ```bash
  npm run build
  ```

### Troubleshooting
- Ensure your `.env` file is correctly configured.
- Check if all required services (e.g., MySQL) are running.
