<?php
// app/public/view.php

require '../config/config.php';
require '../config/conf.php';
require '../controllers/UserController.php';

$userController = new UserController($conn);

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = $userController->viewUser ($userId); // Fetch user details by ID

    if (!$user) {
        echo "User  not found.";
        exit;
    }
} else {
    echo "No user ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <title>User Details</title>

    <style>
        .section-title {
            font-size: 18px;
            font-weight: bold;
            padding: 8px 0;
            border-bottom: 2px solid #ccc;
            margin-top: 20px;
        }

        /* Info Container */
        .info-container {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        /* Styling individual info */
        .info-container p {
            margin: 8px 0;
            font-size: 14px;
        }

        .sidebar a{
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: weight;
            font-style: normal;
        }

        .sidebar h2{
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: weight;
            font-style: normal;
        }

        .content{
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: weight;
            font-style: normal;
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .info-grid p {
            flex: 1 1 calc(33.333% - 20px); /* Each item takes 1/3 of the width */
            min-width: 250px; /* Prevents items from shrinking too much */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-sitemap"></i>  CJPG</h2>
        <a href="index.php">User  List</a>
        <a href="form.php">Add New User</a>
        <!-- Add more links as needed -->
    </div>
    <div class="content">
        <h1>User Details</h1>

        <div class="info-container">
            <h2 class="section-title">Personal Information</h2>
            <div class="info-grid">
                <p>Last Name: <?php echo htmlspecialchars($user['last_name']); ?></p>
                <p>First Name: <?php echo htmlspecialchars($user['first_name']); ?></p>
                <p>Middle Initial: <?php echo htmlspecialchars($user['middle_initial']); ?></p>
                <p>Date of Birth: <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
                <p>Gender: <?php echo htmlspecialchars($user['gender']); ?></p>
                <p>Civil Status: <?php echo htmlspecialchars($user['civil_status'] === 'Other' ? $user['other_civil_status'] : $user['civil_status']); ?></p>
                <p>Tax Identification Number: <?php echo htmlspecialchars($user['tax_identification_number']); ?></p>
                <p>Nationality: <?php echo htmlspecialchars($user['nationality']); ?></p>
                <p>Religion: <?php echo htmlspecialchars($user['religion']); ?></p>
            </div>
        </div>


        <div class="info-container">
            <h2 class="section-title">Place of Birth</h2>
            <div class="info-grid">
                <p>City: <?php echo htmlspecialchars($user['place_of_birth_city']); ?></p>
                <p>Province: <?php echo htmlspecialchars($user['place_of_birth_province']); ?></p>
                <p>Country: <?php echo htmlspecialchars($user['place_of_birth_country']); ?></p>
            </div>
        </div>

        <div class="info-container">
            <h2 class="section-title">Home Address</h2>
            <div class="info-grid">
                <p>City: <?php echo htmlspecialchars($user['home_address_city']); ?></p>
                <p>Province: <?php echo htmlspecialchars($user['home_address_province']); ?></p>
                <p>Country: <?php echo htmlspecialchars($user['home_address_country']); ?></p>
            </div>
        </div>

        <div class="info-container">
            <h2 class="section-title">Contact Information</h2>
            <div class="info-grid">
                <p>Mobile Number: <?php echo htmlspecialchars($user['mobile_number']); ?></p>
                <p>Email Address: <?php echo htmlspecialchars($user['email_address']); ?></p>
                <p>Telephone Number: <?php echo htmlspecialchars($user['telephone_number']); ?></p>
            </div>
        </div>

        <div class="info-container">
            <h2 class="section-title">Parent's Information</h2>
            <div class="info-grid">
                <p>Father's Last Name: <?php echo htmlspecialchars($user['father_last_name']); ?></p>
                <p>Father's First Name: <?php echo htmlspecialchars($user['father_first_name']); ?></p>
                <p>Father's Middle Name: <?php echo htmlspecialchars($user['father_middle_name']); ?></p>
                <p>Mother's Last Name: <?php echo htmlspecialchars($user['mother_last_name']); ?></p>
                <p>Mother's First Name: <?php echo htmlspecialchars($user['mother_first_name']); ?></p>
                <p>Mother's Middle Name: <?php echo htmlspecialchars($user['mother_middle_name']); ?></p>
            </div>
        </div>
    </div>

</body>
</html>