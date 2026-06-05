<?php
/**
 * Vehicle Termination Page
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = (int)$_POST['vehicle_id'];
    $termination_reason = sanitize($_POST['termination_reason'] ?? '');
    $termination_date = sanitize($_POST['termination_date'] ?? '');
    
    if (!$vehicle_id || !$termination_reason || !$termination_date) {
        echo '<div class="alert alert-danger">Please fill all required fields</div>';
    } else {
        // Update vehicle status to terminated
        $stmt = $conn->prepare('UPDATE vehicles SET status = "terminated", termination_date = ?, termination_reason = ?, updated_at = NOW() WHERE id = ?');
        $stmt->bind_param('ssi', $termination_date, $termination_reason, $vehicle_id);
        
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Vehicle terminated successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Error terminating vehicle: ' . $conn->error . '</div>';
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Terminate Vehicle</h2>
    </div>
    
    <form method="POST" id="terminateForm">
        <div class="form-group">
            <label>Select Vehicle *</label>
            <select name="vehicle_id" required id="vehicleSelect">
                <option value="">Choose a vehicle</option>
                <?php
                $vehicles = $conn->query('SELECT id, registration_number, license_plate, model FROM vehicles WHERE status = "active" ORDER BY registration_number');
                while ($vehicle = $vehicles->fetch_assoc()): ?>
                    <option value="<?php echo $vehicle['id']; ?>">
                        <?php echo $vehicle['registration_number']; ?> - <?php echo $vehicle['model']; ?> (<?php echo $vehicle['license_plate']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Termination Reason *</label>
            <select name="termination_reason" required>
                <option value="">Select reason</option>
                <option value="End of service life">End of service life</option>
                <option value="Accident damage">Accident damage</option>
                <option value="Mechanical failure">Mechanical failure</option>
                <option value="Fleet reduction">Fleet reduction</option>
                <option value="Sold">Sold</option>
                <option value="Scrapped">Scrapped</option>
                <option value="Other">Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Termination Date *</label>
            <input type="date" name="termination_date" required>
        </div>
        
        <div class="form-group">
            <label>Additional Details</label>
            <textarea name="additional_details" rows="4" placeholder="Any additional information about the termination"></textarea>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 4px; margin-bottom: 20px;">
            <strong>⚠️ Warning:</strong> Terminating a vehicle will mark it as inactive. This action is important for fleet management records.
        </div>
        
        <div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to terminate this vehicle?');">Terminate Vehicle</button>
            <a href="?page=vehicles-list" class="btn btn-warning">Cancel</a>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <h2>Terminated Vehicles</h2>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Registration</th>
                <th>Model</th>
                <th>Plate</th>
                <th>Termination Date</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $terminated = $conn->query('SELECT * FROM vehicles WHERE status = "terminated" ORDER BY termination_date DESC');
            if ($terminated->num_rows > 0) {
                while ($vehicle = $terminated->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $vehicle['registration_number']; ?></td>
                        <td><?php echo $vehicle['model']; ?></td>
                        <td><?php echo $vehicle['license_plate']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($vehicle['termination_date'])); ?></td>
                        <td><?php echo $vehicle['termination_reason']; ?></td>
                    </tr>
                <?php endwhile;
            } else {
                echo '<tr><td colspan="5" style="text-align: center; padding: 20px;">No terminated vehicles</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>