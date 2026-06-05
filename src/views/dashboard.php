<?php
/**
 * Dashboard Page
 */

// Get statistics
$total_vehicles = $conn->query('SELECT COUNT(*) as count FROM vehicles WHERE status = "active"')->fetch_assoc()['count'];
$total_routes = $conn->query('SELECT COUNT(*) as count FROM routes WHERE status = "active"')->fetch_assoc()['count'];
$total_bookings = $conn->query('SELECT COUNT(*) as count FROM bookings')->fetch_assoc()['count'];
$revenue = $conn->query('SELECT SUM(amount) as total FROM payments WHERE status = "success"')->fetch_assoc()['total'];
?>

<div class="dashboard-grid">
    <div class="stat-card success">
        <h3>Active Vehicles</h3>
        <div class="stat-value"><?php echo $total_vehicles; ?></div>
        <div class="stat-change">+5 this month</div>
    </div>
    
    <div class="stat-card info">
        <h3>Total Routes</h3>
        <div class="stat-value"><?php echo $total_routes; ?></div>
        <div class="stat-change">2 new routes</div>
    </div>
    
    <div class="stat-card warning">
        <h3>Total Bookings</h3>
        <div class="stat-value"><?php echo $total_bookings; ?></div>
        <div class="stat-change">+12% increase</div>
    </div>
    
    <div class="stat-card danger">
        <h3>Revenue</h3>
        <div class="stat-value"><?php echo number_format($revenue, 2); ?></div>
        <div class="stat-change">This month</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Recent Bookings</h2>
        <a href="?page=bookings" class="btn btn-primary btn-sm">View All</a>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Booking Ref</th>
                <th>Passenger</th>
                <th>Route</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bookings = $conn->query('SELECT b.*, r.route_name FROM bookings b JOIN schedules s ON b.schedule_id = s.id JOIN routes r ON s.route_id = r.id ORDER BY b.created_at DESC LIMIT 5');
            while ($booking = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $booking['booking_reference']; ?></td>
                    <td><?php echo $booking['passenger_name']; ?></td>
                    <td><?php echo $booking['route_name']; ?></td>
                    <td><?php echo date('M d, Y', strtotime($booking['travel_date'])); ?></td>
                    <td><?php echo number_format($booking['fare_amount'], 2); ?></td>
                    <td><span class="badge badge-<?php echo $booking['booking_status'] === 'confirmed' ? 'success' : 'warning'; ?>"><?php echo ucfirst($booking['booking_status']); ?></span></td>
                    <td>
                        <a href="?page=booking-detail&id=<?php echo $booking['id']; ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
        <a href="?page=vehicle-register" class="btn btn-primary">Register Vehicle</a>
        <a href="?page=vehicle-terminate" class="btn btn-danger">Terminate Vehicle</a>
        <a href="?page=route-create" class="btn btn-info">Create Route</a>
        <a href="?page=schedule-create" class="btn btn-success">Create Schedule</a>
        <a href="?page=driver-register" class="btn btn-warning">Register Driver</a>
        <a href="?page=reports" class="btn btn-info">View Reports</a>
    </div>
</div>