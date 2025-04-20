<?php
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Display errors on the screen

use MongoDB\Client;
require '../vendor/autoload.php';
$uri = "mongodb+srv://kobikrishna52:Krishna%4052@cluster0.9twqr.mongodb.net/";
header('X-Content-Type-Options: nosniff');
header('Content-Type: application/json');

$client = new Client($uri);
$database = $client->selectDatabase('EcoSpark'); // Your database name
$collection = $database->selectCollection('userData');

// Get POST data
$id = $_POST['id']; // User's email ID used as document _id
 // Duplicate variable with sample value

$fname = $_POST['fname']; // First name
// Duplicate variable with sample value

$lname = $_POST['lname']; // Last name
// Duplicate variable with sample value

$dob = $_POST['dob']; // Date of birth
 // Duplicate variable with sample value

$age = $_POST['age']; // Age
// Duplicate variable with sample value

$gender = $_POST['gender']; // Gender
 // Duplicate variable with sample value

$mobile = $_POST['mobile']; // Mobile number
// Duplicate variable with sample value

$state = $_POST['state']; // State
 // Duplicate variable with sample value

$district = $_POST['district']; // District
 // Duplicate variable with sample value

$pincode = $_POST['pincode']; // Pincode
// Duplicate variable with sample value

$address = $_POST['address']; // Address
 // Duplicate variable with sample value

try {
    $result = $collection->updateOne(
        ['_id' => $id],
        ['$set' => [
            'fname' => $fname,
            'lname' => $lname,
            'dob' => $dob,
            'age' => $age,
            'gender' => $gender,
            'mobile' => $mobile,
            'state' => $state,
            'district' => $district,
            'pincode' => $pincode,
            'address' => $address
        ]]
    );

    if ($result->getModifiedCount() > 0) {
        $response = [
            '_id' => $id,
            'fname' => $fname,
            'lname' => $lname,
            'dob' => $dob,
            'age' => $age,
            'gender' => $gender,
            'mobile' => $mobile,
            'state' => $state,
            'district' => $district,
            'pincode' => $pincode,
            'address' => $address
        ];
    } else {
        $response = ['error' => 'No documents matched the query.'];
    }
} catch (MongoDB\Exception\Exception $e) {
    $response = ['error' => 'Error updating document: '];
}

echo json_encode($response);
