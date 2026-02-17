# Ecommerce

#  E-Commerce Website (PHP & MySQL)

##  Project Description

This is a simple **E-commerce web application** developed using **PHP, MySQL, HTML, CSS, and JavaScript**.
It allows users to browse products, and admin can manage products through an admin panel.



##  Features

###  User Side

* View products
* Product details page
* Add to cart (optional)
* Simple UI for browsing

###  Admin Side

* Admin login
* Add products
* Manage products
* Upload product images
* View product list


##  Technologies Used

* Frontend: HTML, CSS
* Backend: PHP
* Database: MySQL
* Server: XAMPP (Apache & MySQL)



##  Database Setup

1. Open phpMyAdmin
2. Create database:


ecommerce


3. Create products table:




##  Project Setup (Run Locally)

### Step 1: Install XAMPP

Download and install XAMPP.

### Step 2: Start Server

Open XAMPP Control Panel → Start:

* Apache
* MySQL

### Step 3: Move Project Folder

Copy project folder to:


C:\xampp\htdocs\ecommerce


### Step 4: Configure Database

Open:

includes/db.php


Set database details:


$conn = mysqli_connect("localhost","root","","ecommerce");


### Step 5: Run Project

Open browser:


http://localhost/ecommerce


Admin panel:


http://localhost/ecommerce/admin/login.php

##  Project Structure


ecommerce/
│
├── admin/           → admin panel files
├── includes/        → database connection
├── images/          → product images
├── index.php        → homepage
└── test_db.php      → database test file


##  Learning Objectives

* Understand PHP & MySQL connection
* CRUD operations (Create, Read, Update, Delete)
* Admin login system
* File upload in PHP
* Basic full stack development



##  Author

Developed by: **Vamsinath**

Technology: PHP & MySQL Full Stack Project



##  Future Improvements

* Add to cart system
* Payment gateway
* User login/signup
* Search products
* Responsive UI



**This project is for learning and academic purposes.**
