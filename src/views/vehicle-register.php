<?php
/**
 * Vehicle Registration Page
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_no = sanitize($_POST['registration_number'] ?? '');
    $vehicle_type = sanitize($_POST['vehicle_type'] ?? '');
    $manufacturer = sanitize($_POST['manufacturer'] ?? '');
    $model = sanitize($_POST['model'] ?? '');
    $year = (int)($_POST['year_of_manufacture'] ?? 0);
    $capacity = (int)($_POST['capacity'] ?? 0);
    $license_plate = sanitize($_POST['license_plate'] ?? '');
    $vin = sanitize($_POST['vin_number'] ?? '');
    $color = sanitize($_POST['color'] ?? '');
    $fuel_type = sanitize($_POST['fuel_type'] ?? '');
    $purchase_date = sanitize($_POST['purchase_date'] ?? '');
    $reg_date = sanitize($_POST['registration_date'] ?? '');
    $insurance_no = sanitize($_POST['insurance_number'] ?? '');
    $insurance_expiry = sanitize($_POST['insurance_expiry'] ?? '');
    $owner_name = sanitize($_POST['owner_name'] ?? '');
    $owner_phone = sanitize($_POST['owner_phone'] ?? '');
    $owner_address = sanitize($_POST['owner_address'] ?? '');
    
    // Validate required fields
    if (!$reg_no || !$vehicle_type || !$capacity || !$license_plate || !$reg_date) {
        echo '<div class="alert alert-danger">Please fill all required fields</div>';
    } else {
        // Check if registration number already exists
        $check = $conn->prepare('SELECT id FROM vehicles WHERE registration_number = ?');
        $check->bind_param('s', $reg_no);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            echo '<div class="alert alert-danger">Vehicle with this registration number already exists</div>';
        } else {
            // Insert vehicle
            $stmt = $conn->prepare('INSERT INTO vehicles (registration_number, vehicle_type, manufacturer, model, year_of_manufacture, capacity, license_plate, vin_number, color, fuel_type, purchase_date, registration_date, insurance_number, insurance_expiry, owner_name, owner_phone, owner_address, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, "active", ?)');
            
            $stmt->bind_param('ssssiissssssssssi', $reg_no, $vehicle_type, $manufacturer, $model, $year, $capacity, $license_plate, $vin, $color, $fuel_type, $purchase_date, $reg_date, $insurance_no, $insurance_expiry, $owner_name, $owner_phone, $owner_address, $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Vehicle registered successfully!</div>';
            } else {
                echo '<div class="alert alert-danger">Error registering vehicle: ' . $conn->error . '</div>';
            }
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Register New Vehicle</h2>
    </div>
    
    <form method="POST" id="vehicleForm">
        <div class="form-row">
            <div class="form-group">
                <label>Registration Number *</label>
                <input type="text" name="registration_number" required placeholder="e.g., KK-123-AB">
            </div>
            <div class="form-group">
                <label>Vehicle Type *</label>
                <select name="vehicle_type" required>
                    <option value="">Select type</option>
                    <option value="bus">Bus</option>
                    <option value="minibus">Minibus</option>
                    <option value="coach">Coach</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Manufacturer</label>
                <input type="text" name="manufacturer" placeholder="e.g., Volvo, Scania">
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" name="model" placeholder="e.g., B11R, R440">
            </div>
            <div class="form-group">
                <label>Year of Manufacture</label>
                <input type="number" name="year_of_manufacture" placeholder="e.g., 2020">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Capacity (Seats) *</label>
                <input type="number" name="capacity" required placeholder="e.g., 52">
            </div>
            <div class="form-group">
                <label>License Plate *</label>
                <input type="text" name="license_plate" required placeholder="e.g., KK123AB">
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" placeholder="e.g., White, Blue">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>VIN Number</label>
                <input type="text" name="vin_number" placeholder="Vehicle Identification Number">
            </div>
            <div class="form-group">
                <label>Fuel Type</label>
                <select name="fuel_type">
                    <option value="diesel">Diesel</option>
                    <option value="petrol">Petrol</option>
                    <option value="electric">Electric</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date">
            </div>
            <div class="form-group">
                <label>Registration Date *</label>
                <input type="date" name="registration_date" required>
            </div>
        </div>
        
        <h3 style="margin-top: 30px; margin-bottom: 15px;">Insurance Information</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label>Insurance Number</label>
                <input type="text" name="insurance_number" placeholder="Insurance policy number">
            </div>
            <div class="form-group">
                <label>Insurance Expiry Date</label>
                <input type="date" name="insurance_expiry">
            </div>
        </div>
        
        <h3 style="margin-top: 30px; margin-bottom: 15px;">Owner Information</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label>Owner Name</label>
                <input type="text" name="owner_name" placeholder="Owner/Company name">
            </div>
            <div class="form-group">
                <label>Owner Phone</label>
                <input type="tel" name="owner_phone" placeholder="Contact number">
            </div>
        </div>
        
        <div class="form-group">
            <label>Owner Address</label>
            <textarea name="owner_address" rows="3" placeholder="Full address"></textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Register Vehicle</button>
            <a href="?page=vehicles-list" class="btn btn-warning">Cancel</a>
        </div>
    </form>
</div>