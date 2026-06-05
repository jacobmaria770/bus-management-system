<?php
/**
 * User Profile Page
 */

$user = getCurrentUser();
?>

<div class="card">
    <div class="card-header">
        <h2>My Profile</h2>
    </div>
    
    <div style="padding: 20px;">
        <div class="form-row">
            <div class="form-group">
                <label>Name</label>
                <input type="text" value="<?php echo $user['name']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?php echo $user['email']; ?>" disabled>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" value="<?php echo $user['phone']; ?>" disabled>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" value="<?php echo ucfirst($user['role']); ?>" disabled>
            </div>
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea disabled rows="3"><?php echo $user['address']; ?></textarea>
        </div>
        
        <div>
            <button class="btn btn-primary" onclick="alert('Edit profile feature coming soon!')">Edit Profile</button>
            <button class="btn btn-warning" onclick="alert('Change password feature coming soon!')">Change Password</button>
        </div>
    </div>
</div>