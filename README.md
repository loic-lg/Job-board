# Job Board

## Project Description

The **Job Board** is a web application that allows users to view, apply for, and manage job advertisements. The project features a CRUD system for job advertisements, applicants, job applications, and companies. The system is developed using **HTML**, **CSS**, **JavaScript**, **PHP**, and **MySQL**.

The key features include:
- A user-friendly interface displaying job ads.
- An API for dynamic data retrieval and management.
- A secure admin panel for managing all data related to jobs, companies, and applicants.

## Table of contents

- [Project Description](#project-description)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [Usage](#usage)
- [Admin Panel](#admin-panel)
- [Future Improvements](#future-improvements)

## Features

1. **Job Advertisement Board**:
   - Displays job ads with title, description, location, salary, and working hours.
   - "Learn More" button reveals full job details without reloading the page.

2. **Job Application**:
   - Each ad has an "Learn more" button that opens a side panel with a job description part and a button just for apply to the job.

3. **Authentication**:
   - Users can create, log in and modify their accounts.
   - When logged in, The informations of the account is automatically taken from the user's profile for the job application.

4. **Admin Part**:
   - Admins can perform CRUD operations on all database tables: advertisements, companies, people, and job_applications.
   - Access is restricted to admin users, who can list, create, update, and delete every entry on the database.

## Technologies used

- **Front-End**: HTML, CSS, JavaScript
- **Back-End**: PHP (for API and server-side logic)
- **Database**: MySQL
- **Web Server**: Apache (or any other PHP-compatible server)

## Installation

To run this project locally, follow the steps below to install **XAMPP** (which includes Apache, PHP, and MySQL), set up the database, and start the project.

### 1. Install XAMPP (Apache, PHP, and MySQL)

XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends. It includes the Apache HTTP Server, MariaDB/MySQL database, and interpreters for scripts written in PHP and Perl.

#### For Windows:
1. Download XAMPP from [Apache Friends' official website](https://www.apachefriends.org/index.html).
2. Once the installation is complete, launch the XAMPP Control Panel.

#### For Linux (Ubuntu):
1. Open your terminal and run the following command to download XAMPP:
   ```bash
   wget https://www.apachefriends.org/xampp-files/7.4.30/xampp-linux-x64-7.4.30-0-installer.run
   ```
Make the installer executable:
```bash
sudo chmod +x xampp-linux-x64-7.4.30-0-installer.run
```
Run the installer:
```bash
sudo ./xampp-linux-x64-7.4.30-0-installer.run
```
Follow the graphical installation setup wizard.
#### For macOS:
Download XAMPP from the Apache Friends website.
Run the .dmg file to install XAMPP.
After installation, launch XAMPP and start Apache and MySQL services.

2. Start Apache and MySQL
After installation, open the XAMPP Control Panel:

Start Apache (this starts the web server).
Start MySQL (this starts the database).
In Linux, you can start the services using terminal commands:

```bash
sudo /opt/lampp/lampp start
```

3. Clone the Repository
Open a terminal and navigate to the directory where you want to store your project. Then, clone the repository:

```bash
git clone https://github.com/your-username/project-name.git
```
Replace your-username with your GitHub username and navigate to the project directory:

```bash
cd directory/name/project-name
```

4. Configure the Database

Open phpMyAdmin in your browser by navigating to http://localhost/phpmyadmin/.
Create a new database called job_board.

Import the provided SQL file (job_board.sql) from your project folder into the job_board database:

In phpMyAdmin, go to the Import tab, select the job_board.sql file, and click Go.
Update the php file in the project folder created for the connection to the database.

```php
<?php
$host = 'localhost';
$db = 'job_board'; // The name of the database
$user = 'root';    // The name of the user you created
$pass = '';        // The password you choose
?>
```

5. Place the Project in the XAMPP Directory

Copy the project folder to the "htdocs" directory of XAMPP:

6. Start the Website Locally

Once everything is configured:

Open your browser and go to http://localhost/project-name/.
The homepage should now display the job board.
