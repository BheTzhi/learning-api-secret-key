# Learning API SECRET KEY

This is a simple Laravel API that uses secret key for authentication. The application includes endpoints and view a student data, courses, and departments.

## Requirements

- PHP >= 7.4
- Composer
- Laravel 8.x or above
- MySQL or compatible database
- Postman (for testing endpoints)

## Installation

Follow these steps to get your local envoriment up and running.

1. **Clone the Repository**
    Clone the repository to your local machine:
    ```bash
    git clone https://github.com/BheTzhi/learning-api-secret-key.git
    ```

2. **Install Dependencies**
    Navigate to the project directory and install the required dependencies via Composer:
    ```cd learning-api-secret-key (your project name)
    composer install
    ```

3. **Configure Environment Variables**
    Edit the `.env` file to match your local database configuration.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

4. **Run Migrations and Seed Data**
    Run the migrations to create the required tables in your database:
    ```bash
    php artisan migrate
    ```
    Seed the database with sample data:
    ```bash
    php artisan db:seed
    ```

5. **Start the Development Server**
    Run the development server to start the API:
    ```bash
    php artisan serve
    ```

The Api will be access at `http://127.0.0.1:8000` .

## ✨ Main Features

- Laravel-based RESTful API
- Secure access using custom API Key in HTTP headers
- Custom middleware for student identity verification
- Modular structure using Models, Controllers, and Middleware
- Student data including courses, departments, and KHS (grade reports)
- Sample seed data for quick testing

## 📁 Project Structure

```
learning-api-secret-key/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # API Controllers
│   │   └── Middleware/          # Custom Middleware (e.g. VerifyApiSecret)
│   └── Models/                  # Eloquent Models: Mahasiswa, Jurusan, Matakuliah
├── routes/
│   └── api.php                  # API route definitions
├── database/
│   ├── migrations/              # Database table structures
│   └── seeders/                 # Sample data seeders
├── .env                         # Environment configuration
└── README.md                    # Project documentation
```

## 🖼️ Sample JSON Response

Here's an example of the JSON response returned from the `/mahasiswa/khs` endpoint:

```json
{
  "nim": "12345",
  "name": "Ahmad Fauzi",
  "semester": "4",
  "khs": [
    {
      "course": "Web Programming",
      "credits": 3,
      "grade": "A"
    },
    {
      "course": "Database Systems",
      "credits": 2,
      "grade": "B+"
    }
  ]
}
```

## Live Demo

If you want to try the API without setting up locally, you can access the deployed version here:

🔗 [https://learning-api-secret-keys-production.up.railway.app/api/mahasiswa](https://learning-api-secret-keys-production.up.railway.app/api/mahasiswa)

You can test other endpoints by adjusting the URL, for example:

- All Students: `GET /api/mahasiswa`
- All Departments: `GET /api/jurusan`
- All Courses: `GET /api/matakuliah`

Feel free to try these endpoints using tools like Postman or REST Client (in VSCode).

> Note: For the `/mahasiswa/khs` endpoint, you still need to include the `X-API-KEY` header and the `nim` query parameter as described in the documentation.

# Endpoints

Here are the available API routes:

## Public Endpoints
* **Get All Students**: `GET /mahasiswa`
    Retrieves a list of all students.
* **Get All Departments**: `GET /jurusan`
Retrieves a list of all departments.

* **Get All Courses**: `GET /matakuliah`
Retrieves a list of all courses.

* **Get Student by ID**: `GET /mahasiswa/{id}`
Retrieves a specific student by ID.

* **Get Department by ID**: `GET /jurusan/{id}`
Retrieves a specific department by ID.

* **Get Course by ID**: `GET /matakuliah/{id}`
Retrieves a specific course by ID.

## Private Endpoint
* **Get Student KHS**: `GET /mahasiswa/khs`
This endpoint requires authentication using API key and semester information.

Headers:
* `X-API-KEY` (The API key stored in the mahasiswa table in your database)
* `X-API-SEMESTER` (Optional, semester information)

Query Parameters:
* `nim` (Student NIM)

Example Request (Postman):
```bash
GET http://127.0.0.1:8000/mahasiswa/khs?nim=12345
```

Headers:
* `X-API-KEY: your_api_key`
* `X-API-SEMESTER: 4` (1-8 or null optional)

## Middleware
The `/mahasiswa/khs` endpoint is protected by the `verify.mahasiswa` middleware. This middleware verifies the student's identity by checking the `X-API-KEY` header against the key stored in the `mahasiswa` table and validates the `nim` query parameter.

## Where to Find `X-API-KEY`
The `X-API-KEY` is generated and stored in the `mahasiswa` table in the database. This key is assigned when the student record is created and can be retrieved by querying the `mahasiswa` table for the corresponding student's record. Ensure that this key is kept secure and used properly in the headers for authenticated requests.

## Example Request Using Postman
To test the endpoints, you can use Postman by sending requests with the appropriate headers.

* Get All Students:
    `GET http://127.0.0.1:8000/mahasiswa`

* Get Student KHS:
    `GET http://127.0.0.1:8000/mahasiswa/khs?nim=12345`
    
    Headers:
    * `X-API-KEY: your_api_key`
    * `X-API-SEMESTER: 2025-1 (optional)`

## Contributing
Feel free to submit issues or create pull requests if you have improvements or bug fixes. Contributions are always welcome!

## License
This project is open source and available under the MIT License.

## 👤 Author

BheTzhi

## 🕋 Bismillah
This project is built as a learning tool and to demonstrate Laravel integration with SECRET KEY.

May it be useful and bring barakah.