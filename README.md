# my_shop

![logo](https://user-images.githubusercontent.com/77274953/108516221-3ef0ed80-72c6-11eb-84dd-21571ee8d1f8.png)


delivery method: myshop on Github
language: PHP, HTML, CSS



## Content

    admin.php        edit-category.php  (node_modules)        signin.php
    (assets)          edit-product.php    package.json         signup.php
    (core)            edit-user.php       package-lock.json    viewproduct.php
    (database dump)  (includes)          (products)
    DBconfig.php     index.php           README.md
    delete.php       logout.php          search-results.php


 Folders & website Hierachy


                    |-----------------------------------|
        ----------->|              my_shop              |<-----------------------------------------------
        |           |-----------------------------------|                              |                |
        |                             ^             ^                                  |                |
        |                            /               \                                 |                |
        |                           /                 \                                |                |
    |--------|	    |-------------------------|             |------------|      |-----------|      |----------|
    | Core   |      |     database dump       |--contain--->|   products |      |  includes |      |  assets  |
    |--------|      |-------------------------|             |------------|      |-----------|      |----------|
        ^                   ^      ^                          ^  ^                  ^                ^
        |                  /        \                         |  |                  |                |
        |                 /          \                        |  |                  |                |
        |                /           |--------------|         |  |           |-----------|       |-----------|
        |           privileged       |  my_shop.sql |---------|  |           |  layouts  |       | css & scss|
        |             access         |--------------|            |           |-----------|       |-----------|
        |             /                                        of each 
        |            /                                           |
        |----------------|                                  |------------|
        |     admin      |                                  |     IMG    |
        |----------------|                                  |------------|




## Installation

* Download the folder from the following link [my_shop](https://github.com/EpitechIT2020/C-RDG-114-FR-1-2-myshop-jade.lecuyer).

* Extract the ZIP’s contents into the current directory.

* Run files on Apache server


## Usage

During the installation, if you encounter any problem, please try those solutions:

* Compile your Sass to CSS using the sass command
In your terminal, run the following command:

1. Go to the index.php directory using the command 'cd'
2. Run "npm run build"
------------------
------------------
* Import the database into phpmyadmin
In your terminal, run the following command:

1. mysql -u username -p database_name < file.sql


## Features

### INDEX PAGE

* This page is accessible to anyone on the website. This page is the main page of the business site.

* A logout button has been implemented in the page “index.php”.
    1. A reconnection is impossible after disconnection without a new authentication on the server.

### SIGN-UP/SIGN-IN

* Implement a registration form in a page named “signup.php”
    1. The registration page lets you create a new user in a database. This user must have a username, an email and a password.
    2. In this part, we thought about security. Password is crypted?

* Connection form in a page named “signin.php”.
    1. The login page verify the login/mail and the password of the user wanting to log in, and redirect him
    to the admin page.
    2. If some of the form fields are incorrect, the user is redirected to the previous form and display explicit error messages about all the errors found.

### ADMINISTRATION INTERFACE

* This page is accessible once the user is connected. This page is the main page of administrator interface.

* Once connected, the users will have access to an administration page named “admin.php”, if and only if he has administrator rights in the database.

* This page has links to the following features:
1. Displaying all users.
2. Editing a user (with an option to grant them administrator privileges).
3. Deleting a user.
4. Adding a new product.
5. Displaying all products.
6. Editing a product.
7. Deleting a product.

* Product has the following attributes :
1. A name
2. A description
3. A price
4. A picture

### THE SHOP

* Products are displayed on the index page.

* Code is valid W3C.

* Page is responsive.

### CATEGORIES

* It is possible to create new categories of products in the administration panel.

* A category can contain both other categories and products.

### SEARCH BAR

*  A search bar can be implemented and can look for products by category, price, name, and display the results in a dedicated page.

* In addition, the search engine gives the possibility to sort the results (alphabetically, reverse alphabetically, increasing price, decreasing price, etc. . . ).

### BONUS

1. Possibility to upload an avatar and to display it once connected.
2. Cart in fully functionnal
3. Header's content is differrent depending if logged or not
4. Greeting message on the top of the website
5. Products can be sorted by price, by categories



                     _                   _     
                    (_)  _              | |    
         _____ ____  _ _| |_ _____  ____| |__  
        | ___ |  _ \| (_   _) ___ |/ ___)  _ \ 
        | ____| |_| | | | |_| ____( (___| | | |
        |_____)  __/|_| \__) _____)\____)_| |_|
              |_|                              


## License

Copyright© 2021 www.epitech.eu owned by codecademy.com. Powered by Jade Lecuyer & Morgan Briguet. All rights reserved.