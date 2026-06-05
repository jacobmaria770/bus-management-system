-- Bus Management System Database Schema

CREATE DATABASE IF NOT EXISTS `bus_management`;
USE `bus_management`;

-- Users Table
CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20),
  `role` ENUM('admin', 'manager', 'driver', 'passenger') DEFAULT 'passenger',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `address` TEXT,
  `profile_image` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vehicles Table
CREATE TABLE `vehicles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `registration_number` VARCHAR(50) UNIQUE NOT NULL,
  `vehicle_type` ENUM('bus', 'minibus', 'coach') DEFAULT 'bus',
  `manufacturer` VARCHAR(100),
  `model` VARCHAR(100),
  `year_of_manufacture` INT,
  `capacity` INT NOT NULL,
  `license_plate` VARCHAR(50) UNIQUE NOT NULL,
  `vin_number` VARCHAR(100) UNIQUE,
  `color` VARCHAR(50),
  `fuel_type` ENUM('diesel', 'petrol', 'electric', 'hybrid') DEFAULT 'diesel',
  `purchase_date` DATE,
  `registration_date` DATE NOT NULL,
  `insurance_number` VARCHAR(100),
  `insurance_expiry` DATE,
  `owner_name` VARCHAR(100),
  `owner_phone` VARCHAR(20),
  `owner_address` TEXT,
  `status` ENUM('active', 'inactive', 'maintenance', 'terminated') DEFAULT 'active',
  `termination_date` DATE,
  `termination_reason` TEXT,
  `registration_document` VARCHAR(255),
  `insurance_document` VARCHAR(255),
  `created_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Routes Table
CREATE TABLE `routes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `route_name` VARCHAR(100) NOT NULL,
  `route_code` VARCHAR(20) UNIQUE NOT NULL,
  `starting_point` VARCHAR(100) NOT NULL,
  `ending_point` VARCHAR(100) NOT NULL,
  `distance_km` DECIMAL(8, 2),
  `estimated_duration_minutes` INT,
  `stops_count` INT,
  `base_fare` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Route Stops Table
CREATE TABLE `route_stops` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `route_id` INT NOT NULL,
  `stop_name` VARCHAR(100) NOT NULL,
  `stop_order` INT NOT NULL,
  `latitude` DECIMAL(10, 8),
  `longitude` DECIMAL(11, 8),
  `estimated_time_minutes` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Schedules Table
CREATE TABLE `schedules` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `route_id` INT NOT NULL,
  `vehicle_id` INT,
  `driver_id` INT,
  `departure_time` TIME NOT NULL,
  `arrival_time` TIME,
  `days_of_week` VARCHAR(50),
  `available_seats` INT,
  `status` ENUM('active', 'inactive', 'cancelled') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Drivers Table
CREATE TABLE `drivers` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL UNIQUE,
  `license_number` VARCHAR(50) UNIQUE NOT NULL,
  `license_type` VARCHAR(20),
  `license_expiry` DATE,
  `experience_years` INT,
  `blood_group` VARCHAR(10),
  `emergency_contact` VARCHAR(20),
  `license_document` VARCHAR(255),
  `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bookings Table
CREATE TABLE `bookings` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `booking_reference` VARCHAR(50) UNIQUE NOT NULL,
  `passenger_id` INT NOT NULL,
  `schedule_id` INT NOT NULL,
  `travel_date` DATE NOT NULL,
  `seat_number` VARCHAR(10),
  `passenger_name` VARCHAR(100) NOT NULL,
  `passenger_phone` VARCHAR(20) NOT NULL,
  `passenger_email` VARCHAR(100),
  `boarding_point` VARCHAR(100),
  `dropping_point` VARCHAR(100),
  `fare_amount` DECIMAL(10, 2) NOT NULL,
  `booking_status` ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
  `payment_status` ENUM('unpaid', 'paid', 'refunded') DEFAULT 'unpaid',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`passenger_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`schedule_id`) REFERENCES `schedules`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payments Table
CREATE TABLE `payments` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `booking_id` INT NOT NULL,
  `payment_method` ENUM('cash', 'card', 'online_transfer', 'mobile_wallet') DEFAULT 'cash',
  `transaction_id` VARCHAR(100),
  `amount` DECIMAL(10, 2) NOT NULL,
  `status` ENUM('pending', 'success', 'failed') DEFAULT 'pending',
  `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `reference_number` VARCHAR(100),
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trip Records Table
CREATE TABLE `trip_records` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `schedule_id` INT NOT NULL,
  `vehicle_id` INT NOT NULL,
  `driver_id` INT NOT NULL,
  `trip_date` DATE NOT NULL,
  `actual_departure_time` DATETIME,
  `actual_arrival_time` DATETIME,
  `starting_odometer` INT,
  `ending_odometer` INT,
  `fuel_consumed` DECIMAL(8, 2),
  `passengers_count` INT,
  `status` ENUM('scheduled', 'in_progress', 'completed', 'cancelled') DEFAULT 'scheduled',
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`schedule_id`) REFERENCES `schedules`(`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`),
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maintenance Table
CREATE TABLE `maintenance` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `vehicle_id` INT NOT NULL,
  `maintenance_date` DATE NOT NULL,
  `maintenance_type` ENUM('routine', 'preventive', 'repair') DEFAULT 'routine',
  `description` TEXT NOT NULL,
  `cost` DECIMAL(10, 2),
  `service_provider` VARCHAR(100),
  `status` ENUM('scheduled', 'in_progress', 'completed') DEFAULT 'scheduled',
  `next_maintenance_date` DATE,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- GPS Tracking Table
CREATE TABLE `gps_tracking` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `vehicle_id` INT NOT NULL,
  `latitude` DECIMAL(10, 8) NOT NULL,
  `longitude` DECIMAL(11, 8) NOT NULL,
  `speed_kmh` DECIMAL(6, 2),
  `direction` VARCHAR(20),
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE,
  INDEX `idx_vehicle_timestamp` (`vehicle_id`, `timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user
INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`) 
VALUES 
(1, 'Admin User', 'admin@busmanagement.com', '$2y$10$YourHashedPasswordHere', '1234567890', 'admin', 'active'),
(2, 'Manager User', 'manager@busmanagement.com', '$2y$10$YourHashedPasswordHere', '0987654321', 'manager', 'active'),
(3, 'Driver User', 'driver@busmanagement.com', '$2y$10$YourHashedPasswordHere', '5555555555', 'driver', 'active');

-- Insert sample route
INSERT INTO `routes` (`route_name`, `route_code`, `starting_point`, `ending_point`, `distance_km`, `estimated_duration_minutes`, `stops_count`, `base_fare`)
VALUES ('City Center - Airport', 'RT001', 'City Center', 'Airport', 45.5, 90, 5, 500.00);

-- Create indexes for better performance
CREATE INDEX `idx_users_email` ON `users`(`email`);
CREATE INDEX `idx_vehicles_status` ON `vehicles`(`status`);
CREATE INDEX `idx_bookings_passenger` ON `bookings`(`passenger_id`);
CREATE INDEX `idx_bookings_travel_date` ON `bookings`(`travel_date`);
CREATE INDEX `idx_bookings_status` ON `bookings`(`booking_status`);
CREATE INDEX `idx_payments_booking` ON `payments`(`booking_id`);
CREATE INDEX `idx_trip_records_date` ON `trip_records`(`trip_date`);
CREATE INDEX `idx_maintenance_vehicle` ON `maintenance`(`vehicle_id`);