<?php
/**
 * Logout API
 */

require_once '../../config/config.php';

session_destroy();
header('Location: ../../index.php?page=login');
exit;