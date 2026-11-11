# Task Manager — PHP OOP

A web-based task management application developed using PHP, Object-Oriented Programming (OOP), and MySQL.

This project demonstrates backend development fundamentals, CRUD operations, database integration, server-side validation, and a basic MVC-inspired architecture.

## Features

- Create tasks with a title, description, and status.
- View all tasks stored in MySQL.
- Edit existing tasks.
- Delete tasks with a confirmation prompt.
- Track task status: Pending, In Progress, or Completed.
- Server-side input validation.
- CSRF protection for state-changing requests.
- Basic exception handling and error logging.
- Responsive user interface.

## Technologies

- PHP 8
- MySQL
- PDO
- HTML5
- CSS3
- JavaScript
- Git and GitHub

## Project Architecture

The application follows an MVC-inspired architecture with separation of responsibilities:

- **Models:** Represent application entities.
- **Controllers:** Coordinate application operations.
- **Repositories:** Handle database queries using PDO.
- **Services:** Provide reusable validation and CSRF protection.
- **Public:** Contains the application entry points and user interface.

## Installation

**Requirements:** PHP 8.0 or later, MySQL, and the PHP PDO MySQL extension.

1. Clone the repository.
2. Open the project directory.
3. Create the database and tables using `database/schema.sql`.
4. Configure database connection variables if your local settings differ from the defaults.
5. Start the PHP development server:

```bash
php -S localhost:8000 -t public
```

6. Open `http://localhost:8000` in your browser.

## Database Configuration

The application supports the following environment variables:

- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

The default configuration is intended for local development only.

## Learning Outcomes

Through this project, I practiced:

- Object-Oriented Programming in PHP.
- CRUD operations with MySQL and PDO.
- Prepared statements for database queries.
- Separation of concerns and MVC fundamentals.
- Server-side validation.
- CSRF protection.
- Exception handling.
- Web application development.

## Future Improvements

- User authentication and authorization.
- Improved form feedback and error handling.
- Automated testing.
- Task filtering and search.
- Deployment to a production environment.

## Author

Developed as a personal software engineering portfolio project.