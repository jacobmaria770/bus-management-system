# Bus Management System - Setup Guide

## Prerequisites

- XAMPP (Apache 2.4+, PHP 7.4+, MySQL 5.7+)
- Git
- Web Browser

## Installation Steps

### 1. Clone Repository

```bash
# Windows
cd C:\xampp\htdocs

# Mac
cd /Applications/XAMPP/htdocs

# Linux
cd /opt/lampp/htdocs

# Clone the repository
git clone https://github.com/jacobmaria770/bus-management-system.git
cd bus-management-system
```

### 2. Start XAMPP

- Open XAMPP Control Panel
- Click "Start" button for Apache
- Click "Start" button for MySQL

### 3. Create Database

- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Create new database named `bus_management`
- Go to "Import" tab
- Select and import `database/bus_management.sql`

### 4. Configure Application

- Open `config/config.php`
- Update database credentials if needed:
  ```php
  define('DB_HOST', 'localhost');    // Your DB host
  define('DB_USER', 'root');         // Your DB user
  define('DB_PASS', '');             // Your DB password
  define('DB_NAME', 'bus_management'); // Your DB name
  ```

### 5. Create Folders

- Create `uploads/` folder in project root
- Ensure proper permissions (755)

### 6. Access Application

- Open browser: `http://localhost/bus-management-system`
- Use default credentials to login

## Default Login Credentials

### Admin Account
- Email: `admin@busmanagement.com`
- Password: `admin123`

### Manager Account
- Email: `manager@busmanagement.com`
- Password: `admin123`

### Driver Account
- Email: `driver@busmanagement.com`
- Password: `admin123`

## Features Overview

### Vehicle Management
- Register new vehicles with detailed information
- Track vehicle maintenance
- Terminate vehicles with reason documentation
- View vehicle status and history

### Route Management
- Create and manage bus routes
- Define stops and estimated times
- Set base fares
- Track route performance

### Schedule Management
- Create travel schedules
- Assign drivers and vehicles
- Set departure/arrival times
- Define recurring schedules

### Booking System
- Passengers can book tickets online
- Manage seat availability
- Track booking status
- Confirm and cancel bookings

### Driver Management
- Register and manage drivers
- Track license information
- Assign drivers to schedules
- Monitor driver performance

### Payment Processing
- Support multiple payment methods
- Track payment status
- Generate payment reports
- Issue refunds

### Fleet Maintenance
- Schedule maintenance tasks
- Track maintenance costs
- Document service history
- Set maintenance reminders

### Real-time Tracking
- GPS location tracking (ready for integration)
- Speed monitoring
- Route adherence tracking

### Reports & Analytics
- Revenue reports
- Occupancy rates
- Driver performance
- Vehicle utilization
- Booking trends

## Security Features

- Password hashing with bcrypt
- Input validation and sanitization
- SQL injection prevention
- CSRF protection ready
- Session-based authentication
- Role-based access control

## Support & Maintenance

For issues or feature requests, create an issue in the GitHub repository.

## License

MIT License - See LICENSE file for details