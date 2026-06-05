# Bus Management System

A complete web-based bus management system built with PHP, JavaScript, HTML, CSS, and MySQL.

## Features

- **Vehicle Management**: Register and terminate buses with detailed tracking
- **Route Management**: Create and manage bus routes
- **Schedule Management**: Set and manage timetables
- **Booking System**: Online bus ticket booking and reservation
- **Driver Management**: Driver information and assignment
- **Payment Processing**: Process booking payments
- **Real-time Tracking**: Track bus locations (GPS integration ready)
- **Passenger Management**: Manage passenger information
- **Fleet Maintenance**: Track vehicle maintenance
- **Reports & Analytics**: Generate business reports

## Technology Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP)

## Installation & Setup

### Prerequisites
- XAMPP (Apache, MySQL, PHP)
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Steps

1. **Clone the repository** into `htdocs` folder:
   ```bash
   cd C:\xampp\htdocs  # Windows
   cd /Applications/XAMPP/htdocs  # Mac
   cd /opt/lampp/htdocs  # Linux
   
   git clone https://github.com/jacobmaria770/bus-management-system.git
   cd bus-management-system
   ```

2. **Start XAMPP**:
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

3. **Create Database**:
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database named `bus_management`
   - Import `database/bus_management.sql`

4. **Configure Database**:
   - Edit `config/config.php` with your MySQL credentials (default is root with no password)

5. **Access Application**:
   - Open browser: `http://localhost/bus-management-system`

## Default Login Credentials

- **Admin**:
  - Email: admin@busmanagement.com
  - Password: admin123

- **Manager**:
  - Email: manager@busmanagement.com
  - Password: manager123

- **Driver**:
  - Email: driver@busmanagement.com
  - Password: driver123

## Project Structure

```
bus-management-system/
├── config/              # Database configuration
├── database/            # Database schema
├── public/              # Public assets
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Images and icons
├── src/
│   ├── api/            # API endpoints
│   ├── controllers/    # Business logic
│   ├── models/         # Database models
│   └── views/          # HTML templates
├── uploads/            # File uploads directory
├── index.php           # Entry point
└── README.md
```

## License

MIT License