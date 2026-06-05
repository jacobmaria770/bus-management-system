<?php
class Security {
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function needsRehash($hash) {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }

    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = self::generateToken();
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token) {
        if (empty($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) return false;
        if (time() - $_SESSION['csrf_token_time'] > CSRF_TOKEN_DURATION) {
            unset($_SESSION['csrf_token']);
            return false;
        }
        return true;
    }

    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password) {
        $errors = [];
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters.';
        }
        if (PASSWORD_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain uppercase letter.';
        }
        if (PASSWORD_REQUIRE_NUMBERS && !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain number.';
        }
        if (PASSWORD_REQUIRE_SPECIAL && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password must contain special character.';
        }
        return ['valid' => empty($errors), 'errors' => $errors];
    }

    public static function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    public static function checkRateLimit($identifier, $max_attempts = MAX_LOGIN_ATTEMPTS, $window_seconds = LOGIN_ATTEMPT_WINDOW) {
        $cache_key = 'rate_limit_' . $identifier;
        if (!isset($_SESSION[$cache_key])) $_SESSION[$cache_key] = [];
        
        $current_time = time();
        $attempts = array_filter($_SESSION[$cache_key], function($t) use ($current_time, $window_seconds) {
            return $current_time - $t < $window_seconds;
        });
        
        $_SESSION[$cache_key] = array_values($attempts);
        if (count($attempts) >= $max_attempts) return false;
        $_SESSION[$cache_key][] = $current_time;
        return true;
    }

    public static function clearRateLimit($identifier) {
        unset($_SESSION['rate_limit_' . $identifier]);
    }

    public static function logEvent($event, $level = 'info', $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $ip = self::getClientIP();
        $user_id = $_SESSION['user_id'] ?? 'anonymous';
        $log_message = "[$timestamp] [$level] User: $user_id | IP: $ip | Event: $event";
        if (!empty($context)) {
            $log_message .= " | Context: " . json_encode($context);
        }
        if (!is_dir('logs')) mkdir('logs', 0755, true);
        error_log($log_message, 3, 'logs/security.log');
    }

    public static function setSecureHeaders() {
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    }
}
?>