<?php
// app/public/index.php

require '../config/config.php';
require '../config/conf.php';
require '../models/User.php';
require '../controllers/UserController.php';

$userController = new UserController($conn);

// Example of handling a request to display all users
$users = $userController->displayUsers();

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
    <title>Information List</title>
</head>
    <style>
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
    </style>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-sitemap"></i>  CJPG</h2>
        <a href="index.php">Information List</a>
        <a href="form.php">Add New</a>
        <!-- Add more links as needed -->
    </div>
    <div class="content">
        <div class="header">
            <div class="header-info">
                <span>ADMINISTRATOR, <strong>Cedric Jade</strong></span>
                <img src="../img/administrator.jpg" alt="Profile Picture" class="profile-pic">
            </div>
        </div>

        <h1>Personal Information</h1>

        <?php if (isset($_GET['message'])): ?>
            <div class='alert'><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <div class="user-cards">
            <?php foreach ($users as $user): ?>
                <div class="user-card">
                    <div class="user-actions">
                        <a class="edit" href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                        <a class="delete" href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
                    </div>
                    <div class="user-action">
                        <a href="view.php?id=<?php echo $user['id']; ?>" class="user-card-link">
                            <h3><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></h3>
                            <p>Middle Initial: <?php echo htmlspecialchars($user['middle_initial']); ?></p>
                            <p>Date of Birth: <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
                            <p>Gender: <?php echo htmlspecialchars($user['gender']); ?></p>
                            <p>Civil Status: <?php echo htmlspecialchars($user['civil_status']); ?></p>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>