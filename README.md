
# E-Commerce API (Laravel 11)

This project is a RESTful API built with Laravel 11 for managing an e-commerce application. It provides authentication, role-based access, and product management with support for categories and subcategories.

✨ Features

User Authentication (JWT/Token based with roles: admin, user,email verfication,resending email).

Categories & Subcategories

Products can belong to multiple categories and subcategories.

Many-to-many relationships managed with pivot tables.

Products Management

Create, update, delete, and fetch products.

Products can be linked with multiple categories and subcategories.

Image upload support for categories, subcategories, and products.

Middleware for authentication, authorization, and validation.

Localization Ready for future multi-language support.

🚀 Tech Stack

Laravel 11 – PHP backend framework.

MySQL – database.

Sanctum – API authentication.

Postman – API testing.

📌 Example Use Cases

Admin can create categories and subcategories.

Admin can assign products to multiple categories/subcategories.

Users can view all products filtered by category or subcategory.

Role-based API access (e.g., only admins can manage categories).


#### Techanical Notes About Project

  1- I made first side localization (database) in product model.<br>
  2- I made second side localization (responses and messages from backend) in user model in register function.<br>
  3- I made the pagination concept in category model when reterieving all the categories.
  







