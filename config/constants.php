<?php
define('ROLE_ADMIN', 'admin');
define('ROLE_MANAGER', 'manager');
define('ROLE_MANAGER_ASSISTANT', 'manager_assistant');
define('ROLE_DRIVER', 'driver');
define('ROLE_DRIVER_ASSISTANT', 'driver_assistant');
define('ROLE_PASSENGER', 'passenger');

define('AVAILABLE_ROLES', [ROLE_ADMIN, ROLE_MANAGER, ROLE_MANAGER_ASSISTANT, ROLE_DRIVER, ROLE_DRIVER_ASSISTANT, ROLE_PASSENGER]);

define('STATUS_ACTIVE', 'active');
define('STATUS_INACTIVE', 'inactive');
define('STATUS_SUSPENDED', 'suspended');
define('STATUS_ON_LEAVE', 'on_leave');

define('SESSION_TIMEOUT', 3600);
define('REMEMBER_ME_DURATION', 2592000);
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_REQUIRE_UPPERCASE', true);
define('PASSWORD_REQUIRE_NUMBERS', true);
define('PASSWORD_REQUIRE_SPECIAL', true);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_WINDOW', 900);
define('CSRF_TOKEN_DURATION', 3600);

$PERMISSIONS = [
    ROLE_ADMIN => ['users.create', 'users.read', 'users.update', 'users.delete', 'vehicles.create', 'vehicles.read', 'vehicles.update', 'vehicles.delete', 'vehicles.terminate', 'routes.create', 'routes.read', 'routes.update', 'routes.delete', 'schedules.create', 'schedules.read', 'schedules.update', 'schedules.delete', 'drivers.create', 'drivers.read', 'drivers.update', 'drivers.delete', 'bookings.read', 'bookings.approve', 'bookings.cancel', 'payments.read', 'payments.verify', 'reports.financial', 'reports.operational', 'reports.analytics', 'system.settings', 'system.backup', 'system.security', 'system.logs', 'roles.manage', 'permissions.manage'],
    ROLE_MANAGER => ['users.read', 'vehicles.read', 'routes.read', 'schedules.read', 'schedules.create', 'schedules.update', 'drivers.read', 'drivers.assign', 'bookings.read', 'bookings.approve', 'bookings.cancel', 'payments.read', 'reports.operational', 'reports.revenue', 'staff.manage', 'staff.schedule', 'staff.approve_leave', 'incidents.view', 'incidents.escalate'],
    ROLE_MANAGER_ASSISTANT => ['tickets.verify', 'bookings.read', 'passengers.support', 'trip_status.update', 'notifications.send', 'revenue.record', 'incidents.report'],
    ROLE_DRIVER => ['schedules.read', 'trip_records.create', 'trip_records.read', 'trip_records.update', 'trip_status.update', 'incidents.report', 'profile.read', 'profile.update'],
    ROLE_DRIVER_ASSISTANT => ['passengers.support', 'tickets.verify', 'boarding.manage', 'trip_status.update', 'incidents.report', 'profile.read'],
    ROLE_PASSENGER => ['bookings.create', 'bookings.read', 'bookings.update', 'bookings.cancel', 'payments.create', 'payments.read', 'routes.read', 'schedules.read', 'profile.read', 'profile.update', 'feedback.submit', 'tickets.download'],
];
define('ROLE_PERMISSIONS', $PERMISSIONS);
define('BOOKING_PENDING', 'pending');
define('BOOKING_CONFIRMED', 'confirmed');
define('BOOKING_CANCELLED', 'cancelled');
define('BOOKING_COMPLETED', 'completed');
define('PAYMENT_UNPAID', 'unpaid');
define('PAYMENT_PAID', 'paid');
define('PAYMENT_REFUNDED', 'refunded');
define('PAYMENT_FAILED', 'failed');
define('TRIP_SCHEDULED', 'scheduled');
define('TRIP_IN_PROGRESS', 'in_progress');
define('TRIP_COMPLETED', 'completed');
define('TRIP_CANCELLED', 'cancelled');
define('TRIP_DELAYED', 'delayed');
define('VEHICLE_ACTIVE', 'active');
define('VEHICLE_INACTIVE', 'inactive');
define('VEHICLE_MAINTENANCE', 'maintenance');
define('VEHICLE_TERMINATED', 'terminated');
define('INCIDENT_BREAKDOWN', 'breakdown');
define('INCIDENT_ACCIDENT', 'accident');
define('INCIDENT_DELAY', 'delay');
define('INCIDENT_SAFETY', 'safety');
define('INCIDENT_OTHER', 'other');
define('API_SUCCESS', 200);
define('API_CREATED', 201);
define('API_BAD_REQUEST', 400);
define('API_UNAUTHORIZED', 401);
define('API_FORBIDDEN', 403);
define('API_NOT_FOUND', 404);
define('API_CONFLICT', 409);
define('API_SERVER_ERROR', 500);
?>