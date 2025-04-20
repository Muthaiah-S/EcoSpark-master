<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$secretKey = $_ENV['JWT_SECRET']; // The key used for signing

// Get request headers
$headers = getallheaders(); // Works for more server environments

if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    $jwt = str_replace('Bearer ', '', $authHeader);

    try {
        // Decode the JWT using the secret key
        $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));

        // Access granted, return success message with decoded data
        echo json_encode([
            'status' => 'success',
            'message' => 'Access granted to protected endpoint',
            'user' => $decoded->data // Assuming 'data' is the user info stored in the token
        ]);

    } catch (Exception $e) {
        // JWT decode failed
        http_response_code(401); // Unauthorized
        echo json_encode([
            'status' => 'fail',
            'message' => 'Invalid token: ' . $e->getMessage()
        ]);
    }
} else {
    // Authorization header missing
    http_response_code(401); // Unauthorized
    echo json_encode([
        'status' => 'fail',
        'message' => 'Token not provided'
    ]);
}
