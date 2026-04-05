# Travel-Application-Portal

Hey! This is a complete, secure PHP-based web application I built for managing trip registrations. It features a modern, "glassmorphism" UI and a robust backend that handles user authentication and prevents duplicate form submissions.

## 🚀 Features

* **Secure Authentication**: Full login and registration system using `password_hash()` (Bcrypt) to keep user data safe.
* **Modern UI**: A clean, responsive "Glassmorphism" design with smooth transitions and a professional look.
* **One-Time Submission**: The system checks the database and prevents a user from filling out the trip form more than once.
* **SQL Injection Protection**: All database queries are handled via **Prepared Statements** to keep the site secure from common attacks.
* **Auto-Redirects**: If you're logged in, the login/register pages automatically push you to the dashboard. If you're not, the dashboard pushes you to the login.

---

## 🛠️ Project Structure

* `index.php`: The main dashboard and trip application form.
* `login.php` & `register.php`: Entry points for users.
* `db.php`: Centralized database connection settings.
* `logout.php`: Clears the session and signs the user out.
* `style.css`: The "next-level" aesthetic styles.
* [cite_start]`.gitignore`: Keeps sensitive files like `db.php` out of your version control[cite: 1].

---

## 🚦 How to Get Started

### 1. Database Setup
First, create a database named `trip_db` in your local environment (like XAMPP/WAMP). Run the following SQL queries to create the necessary tables:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trip_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    other_info TEXT,
    dt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 2. Configure Connection
Open `db.php` and update the credentials if your local database uses a different username or password.

### 3. Run the App
1. Move the folder to your server directory (e.g., `htdocs`).
2. Open your browser and navigate to `localhost/your-folder-name/register.php`.
3. Create an account, log in, and you’re ready to fill out the trip form!

---

## 🔒 Security Notes
* **Passwords**: We never store plain text. Everything is hashed.
* **Sessions**: We use `session_start()` to keep track of users securely across pages.
* [cite_start]**Environment**: The `.gitignore` file is pre-configured to ensure your database credentials don't end up on public repositories[cite: 1].

Enjoy using the portal!