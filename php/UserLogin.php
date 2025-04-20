<?php
require '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use MongoDB\Client;

class UserManager {
    private $mongoCollection;

    public function __construct($mongoCollection) {
        $this->mongoCollection = $mongoCollection;
    }

    public function userExistsInMongoDB($email, $password) {
        // Find user by email and password
        $existingDocument = $this->mongoCollection->findOne(['_id' => $email, 'password' => $password]);
        return $existingDocument;
    }
}

// MongoDB connection string
$uri = "mongodb+srv://kobikrishna52:Krishna%4052@cluster0.9twqr.mongodb.net/";

header('X-Content-Type-Options: nosniff');
header('Content-Type: application/json');

// Initialize MongoDB
$client = new Client($uri);
$database = $client->selectDatabase('EcoSpark');
$collection = $database->selectCollection('userData');
$userManager = new UserManager($collection);

// Get email and password from POST request
$email = $_POST['mail'] ?? '';
$password = $_POST['password'] ?? '';

// Check if user exists
$user = $userManager->userExistsInMongoDB($email, $password);

if ($user) {
    // Return success status and user data (no token)
    $response = [
        'status' => 'success',
        'fname' => $user['fname'],
        'lname' => $user['lname']
    ];
    echo json_encode($response);
} else {
    // Return failure status
    $response = [
        'status' => 'fail',
        'message' => 'Invalid email or password'
    ];
    echo json_encode($response);
}
