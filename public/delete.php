<?php
// app/public/delete.php

require '../config/config.php';
require '../config/conf.php';
require '../controllers/UserController.php';

$userController = new UserController($conn);

if (isset($_GET['id'])) {
    $userController->deleteUser ($_GET['id']);
    header("Location: index.php?message=" . urlencode("User  deleted successfully!")); // Redirect after deletion
}
?>