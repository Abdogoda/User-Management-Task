# 🧑‍💻 **User Management and Role-Based Access Control (RBAC)**

Welcome to the **User Management and Role-Based Access Control (RBAC)** documentation! This guide will walk you through the implementation of RBAC in a Laravel application with code examples from routes, controllers, middleware, models, migrations, and tests.

---

## 🧩 **Features**
- **User Authentication**: Login, registration, and password reset functionality.
- **Role Management**: Create, update, and assign roles to users.
- **Permissions**: Fine-grained access control based on user roles.
- **Middleware Protection**: Protect routes based on roles and permissions.
- **API Endpoints**: Expose user and role management functionality through RESTful API endpoints.
- **Admin Panel**: Manage users, roles, and permissions from the admin interface.
- **Tests**: Ensure that the application behaves correctly, such as checking if an admin can create roles.

---

## 🛠️ **Setup and Installation**
To get started with this system, follow these installation steps:

### 1. Clone the repository:
```bash
git clone https://github.com/Abdogoda/User-Management-Task.git
```

### 2. Install dependencies:
```bash
cd User-Management-Task
composer install
```

### 3. Set up the `.env` file:
Make sure you have the correct environment variables set in your `.env` file, especially the database connection.

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Migrate the database:
Run the migration commands to set up the necessary tables for users, roles, and permissions.

```bash
php artisan migrate
```

### 5. Seed the database (optional):
You can seed the database with default roles and permissions.

```bash
php artisan db:seed
```

### 6. Serve the application:
```bash
php artisan serve
```

---

## 🔐 **Role-Based Access Control (RBAC)**
RBAC is a method of restricting system access to authorized users based on their roles. In this system, users are assigned specific roles, and each role is granted certain permissions.

### **Roles and Permissions**
Roles define the access level of a user, and permissions define what actions a role can perform.

- **Admin**: Has full access to the application.
- **User**: Limited access to certain resources.
- **Guest**: Access to login and register only.

---

## 🛣️ **Api Endpoints**

| **Method** | **Route**                   | **Controller Method**                 | **Description**                                             | **Access Control**    |
|------------|-----------------------------|---------------------------------------|-------------------------------------------------------------|-----------------------|
| POST       | `/register`                 | `AuthenticationController@register`   | Register a new user                                         | Public                |
| POST       | `/login`                    | `AuthenticationController@login`      | Log in and generate an API token                            | Public                |
| POST       | `/logout`                   | `AuthenticationController@logout`     | Log out and invalidate the current API token                | Authenticated (Sanctum) |
| GET        | `/profile`                  | `AuthenticationController@profile`    | Get the authenticated user's profile information            | Authenticated (Sanctum) |
| GET        | `/permissions`              | `PermissionController@index`          | List all available permissions                              | Authenticated (Sanctum) |
| **User Routes** |                             |                                       | **Routes for user management**                               |                       |
| GET        | `/users`                    | `UserController@index`                | Get a list of all users                                     | Authenticated (Sanctum) |
| POST       | `/users`                    | `UserController@store`                | Create a new user                                           | Authenticated (Sanctum) |
| GET        | `/users/{id}`               | `UserController@show`                 | Get details of a specific user                              | Authenticated (Sanctum) |
| PUT/PATCH  | `/users/{id}`               | `UserController@update`               | Update a specific user                                      | Authenticated (Sanctum) |
| DELETE     | `/users/{id}`               | `UserController@destroy`              | Delete a specific user                                      | Authenticated (Sanctum) |
| **Role Routes** |                             |                                       | **Routes for role management**                               |                       |
| GET        | `/roles`                    | `RoleController@index`                | List all roles                                              | Authenticated (Sanctum) |
| POST       | `/roles`                    | `RoleController@store`                | Create a new role                                           | Authenticated (Sanctum) |
| GET        | `/roles/{id}`               | `RoleController@show`                 | Get details of a specific role                              | Authenticated (Sanctum) |
| PUT/PATCH  | `/roles/{id}`               | `RoleController@update`               | Update a specific role                                      | Authenticated (Sanctum) |
| DELETE     | `/roles/{id}`               | `RoleController@destroy`              | Delete a specific role                                      | Authenticated (Sanctum) |
| **Admin-Only Routes** |                         |                                       | **Routes only accessible by Admin users**                    |                       |
| GET        | `/admin/dashboard`          | `Anonymous (admin check)`             | Get admin dashboard info                                    | Admin Only            |
| **User-Only Routes**  |                         |                                       | **Routes only accessible by User role**                     |                       |
| GET        | `/user/dashboard`           | `Anonymous (user check)`              | Get user dashboard info                                     | User Only             |

---

## 📚 **API Documentation**

### 1. **Postman API Documentation** 📬
You can import the Postman collection from the following path:  [API Documentation (Postman JSON)](api-docs.json)

### 2. **Interactive API Documentation** 🌐
Visit the URL `{domain_name}/request-docs/` in your browser to access an interactive API documentation that allows you to explore and test the API endpoints in real time.

---

## 🗂️ Project Structure
```
User-Management-Task/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/V1
│   │   │   ├── UserController.php           # Manages user-related logic
│   │   │   ├── AuthenticationController.php # Manages authentication-related logic
│   │   │   ├── PermissinoController.php     # Manages permission-related logic
│   │   │   └── RoleController.php           # Manages role-related logic
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php           # Handles role-based access
│   ├── Models/
│   │   ├── User.php                         # User model with roles relationship
│   │   └── Role.php                         # Role model with users relationship
│   ├── Policies/
│   │   ├── UserPolicy.php                   # User Policy to manage permissions
│   │   └── RolePolicy.php                   # Role Policy to manage permissions
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php           # Migration for users
│   │   ├── 2024_11_17_104900_create_roles_table.php           # Migration for roels
│   │   ├── 2024_11_17_104908_create_permissions_table.php     # Migration for permissions
│   │   └── 2024_11_17_105051_create_role_user_table.php       # Pivot table migration
│   │   └── 2024_11_17_105056_create_permission_role_table.php # Pivot table migration
│   └── seeders/
│       └── DatabaseSeeder.php                # Main Seeder class
│       └── RoleSeeder.php                    # Seeder for roles
│       └── PermissionSeeder.php              # Seeder for permissions
│       └── RolePermisssionSeeder.php         # Seeder for role and permissions attachment
│
├── routes/
│   └── api.php                           # Defines the routes for user/role management
│
├── tests/
│   └── Feature/Api/
│       └── AuthenticationTest.php        # Tests for login, register, profile, and logout
│       └── DashboardTest.php             # Tests for user and admin role dashboard
│       └── RoleTest.php                  # Tests for roles functionality
│       └── UserTest.php                  # Tests for users functionality
```
---


## 🔧 Development Tools

- **Laravel 8+**: PHP framework for building the application.
- **Laravel Sanctum**: Simple token-based authentication for APIs.
- **SQLite**: Lightweight database used for easy setup.
- **Postman**: For testing API endpoints.

## Contact 📧
For any questions or feedback, please reach out to me at [your-email@example.com].
