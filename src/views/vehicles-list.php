<?php
/**
 * Vehicles List Page
 */
?>

<div class="card">
    <div class="card-header">
        <h2>All Vehicles</h2>
        <div>
            <a href="?page=vehicle-register" class="btn btn-primary btn-sm">Register Vehicle</a>
            <a href="?page=vehicle-terminate" class="btn btn-danger btn-sm">Terminate Vehicle</a>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Registration</th>
                <th>Type</th>
                <th>Model</th>
                <th>Capacity</th>
                <th>Plate</th>
                <th>Status</th>
                <th>Reg. Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $vehicles = $conn->query('SELECT * FROM vehicles ORDER BY registration_date DESC');
            while ($vehicle = $vehicles->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $vehicle['registration_number']; ?></td>
                    <td><?php echo ucfirst($vehicle['vehicle_type']); ?></td>
                    <td><?php echo $vehicle['model']; ?></td>
                    <td><?php echo $vehicle['capacity']; ?></td>
                    <td><?php echo $vehicle['license_plate']; ?></td>
                    <td>
                        <span class="badge badge-<?php 
                            if ($vehicle['status'] === 'active') echo 'success';
                            elseif ($vehicle['status'] === 'inactive') echo 'warning';
                            elseif ($vehicle['status'] === 'maintenance') echo 'info';
                            else echo 'danger';
                        ?>"><?php echo ucfirst($vehicle['status']); ?></span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($vehicle['registration_date'])); ?></td>
                    <td>
                        <div class="table-actions">
                            <a href="?page=vehicle-detail&id=<?php echo $vehicle['id']; ?>" class="btn btn-info btn-sm">View</a>
                            <a href="?page=vehicle-edit&id=<?php echo $vehicle['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>