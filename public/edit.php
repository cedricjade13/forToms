<?php
// app/public/edit.php

require '../config/config.php';
require '../config/conf.php';
require '../controllers/UserController.php';

$userController = new UserController($conn);

if (isset($_GET['id'])) {
    $user = $userController->viewUser  ($_GET['id']);
    if (!$user) {
        die("User not found");
    }
}

$errors = []; // Initialize an array to hold error messages
$data = $user; // Pre-fill the form with user data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST; // Assuming data is coming from a form

    // Validate names
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['last_name'])) {
        $errors['last_name'] = "Last name must not contain numbers.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['first_name'])) {
        $errors['first_name'] = "First name must not contain numbers.";
    }
    // Updated validation for middle initial to accept only one letter
    if (!preg_match("/^[a-zA-Z]$/", $data['middle_initial'])) {
        $errors['middle_initial'] = "Middle initial must be a single letter.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['father_last_name'])) {
        $errors['father_last_name'] = "Father's last name must not contain numbers.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['father_first_name'])) {
        $errors['father_first_name'] = "Father's first name must not contain numbers.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['mother_last_name'])) {
        $errors['mother_last_name'] = "Mother's last name must not contain numbers.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['mother_first_name'])) {
        $errors['mother_first_name'] = "Mother's first name must not contain numbers.";
    }

    // Validate date of birth (must be at least 18 years old)
    $dateOfBirth = new DateTime($data['date_of_birth']);
    $today = new DateTime();
    $age = $today->diff($dateOfBirth)->y;
    if ($age < 18) {
        $errors['date_of_birth'] = "You must be at least 18 years old.";
    }

    // Validate tax identification number (must be numeric)
    if (!preg_match("/^\d+$/", $data['tax_identification_number'])) {
        $errors['tax_identification_number'] = "Tax Identification Number must be numeric.";
    }

    // Validate mobile number (must be 11 to 15 digits)
    if (!preg_match("/^\d{11,15}$/", $data['mobile_number'])) {
        $errors['mobile_number'] = "Mobile Number must be between 11 and 15 digits.";
    }

    // Validate email address (already validated by HTML5)
    if (!filter_var($data['email_address'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_address'] = "Email Address must be in a valid format.";
    }

    // If there are no errors, proceed with user update
    if (empty($errors)) {
        if ($userController->updateUser  ($data['id'], $data)) {
            $message = "Information updated successfully!";
            header("Location: index.php?message=" . urlencode($message)); // Redirect with message
            exit; // Ensure no further code is executed after redirect
        } else {
            $message = "Error updating user.";
        }
    }
}

// Function to generate country dropdown
function country_dropdown($name, $selected = null) {
    $countries = [
        "USA" => "United States",
        "Canada" => "Canada",
        "UK" => "United Kingdom",
        "Australia" => "Australia",
        // Add more countries as needed
    ];

    $html = "<select name='{$name}' required>";
    $html .= "<option value=''>Select Country</option>"; // Default option

    foreach ($countries as $code => $country) {
        $isSelected = ($code === $selected) ? "selected" : "";
        $html .= "<option value='{$code}' {$isSelected}>{$country}</option>";
    }

    $html .= "</select>";
    return $html;
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


    <title>Edit Information</title>
    <style>
        .error {
            color: red; /* Set error message color to red */
            font-size: 0.9em; /* Optional: make the font size smaller */
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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><i class="fa-solid fa-sitemap"></i>  CJPG</h2>
        <a href="index.php">Information  List</a>
        <a href="form.php">Add New</a>
        <!-- Add more links as needed -->
    </div>
    <div class="content">
        <h1>Edit Information</h1>
        <form method="POST" action="edit.php?id=<?php echo $user['id']; ?>">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <input type="text" name="last_name" value="<?php echo htmlspecialchars($data['last_name']); ?>" placeholder="Last Name" required>
            <?php if (isset($errors['last_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['last_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="first_name" value="<?php echo htmlspecialchars($data['first_name']); ?>" placeholder="First Name" required>
            <?php if (isset($errors['first_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['first_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="middle_initial" value="<?php echo htmlspecialchars($data['middle_initial']); ?>" placeholder="Middle Initial" required>
            <?php if (isset($errors['middle_initial'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['middle_initial']); ?></div>
            <?php endif; ?>

            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($data['date_of_birth']); ?>" required>
            <?php if (isset($errors['date_of_birth'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['date_of_birth']); ?></div>
            <?php endif; ?>

            <div class="gender-selection">
                <label for="gender_male">
                    <input type="radio" name="gender" value="Male" id="gender_male" required <?php echo (isset($data['gender']) && $data['gender'] === 'Male') ? 'checked' : ''; ?>>
                    Male
                </label>

                <label for="gender_female">
                    <input type="radio" name="gender" value="Female" id="gender_female" required <?php echo (isset($data['gender']) && $data['gender'] === 'Female') ? 'checked' : ''; ?>>
                    Female
                </label>
            </div>

            <select name="civil_status" id="civil_status" required>
                <option value="">Select Civil Status</option>
                <option value="Single" <?php echo (isset($data['civil_status']) && $data['civil_status'] === 'Single') ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo (isset($data['civil_status']) && $data['civil_status'] === 'Married') ? 'selected' : ''; ?>>Married</option>
                <option value="Widowed" <?php echo (isset($data['civil_status']) && $data['civil_status'] === 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                <option value="Divorced" <?php echo (isset($data['civil_status']) && $data['civil_status'] === 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                <option value="Other" <?php echo (isset($data['civil_status']) && $data['civil_status'] === 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <input type="text" id="other_civil_status" name="other_civil_status" placeholder="Other Civil Status" value="<?php echo htmlspecialchars($data['other_civil_status'] ?? ''); ?>" style="display: none;">
            
            <input type="text" name="tax_identification_number" value="<?php echo htmlspecialchars($data['tax_identification_number']); ?>" placeholder="Tax Identification Number" required>
            <?php if (isset($errors['tax_identification_number'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['tax_identification_number']); ?></div>
            <?php endif; ?>

            <input type="text" name="nationality" value="<?php echo htmlspecialchars($data['nationality']); ?>" placeholder="Nationality" required>
            <input type="text" name="religion" value="<?php echo htmlspecialchars($data['religion']); ?>" placeholder="Religion" required>

            <input type="text" name="place_of_birth_city" value="<?php echo htmlspecialchars($data['place_of_birth_city']); ?>" placeholder="City of Birth" required>
            <input type="text" name="place_of_birth_province" value="<?php echo htmlspecialchars($data['place_of_birth_province']); ?>" placeholder="Province of Birth" required>
            <?php echo country_dropdown('place_of_birth_country', $data['place_of_birth_country']); ?>
            <?php if (isset($errors['country'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['country']); ?></div>
            <?php endif; ?>

            <input type="text" name="home_address_city" value="<?php echo htmlspecialchars($data['home_address_city']); ?>" placeholder="Home Address - City" required>
            <input type="text" name="home_address_province" value="<?php echo htmlspecialchars($data['home_address_province']); ?>" placeholder="Home Address - Province" required>
            <?php echo country_dropdown('home_address_country', $data['home_address_country']); ?>
            <?php if (isset($errors['country'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['country']); ?></div>
            <?php endif; ?>

            <input type="text" name="mobile_number" value="<?php echo htmlspecialchars($data['mobile_number']); ?>" placeholder="Mobile Number" required>
            <?php if (isset($errors['mobile_number'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['mobile_number']); ?></div>
            <?php endif; ?>

            <input type="email" name="email_address" value="<?php echo htmlspecialchars($data['email_address']); ?>" placeholder="Email Address" required>
            <?php if (isset($errors['email_address'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['email_address']); ?></div>
            <?php endif; ?>

            <input type="text" name="telephone_number" value="<?php echo htmlspecialchars($data['telephone_number']); ?>" placeholder="Telephone Number">

            <input type="text" name="father_last_name" value="<?php echo htmlspecialchars($data['father_last_name']); ?>" placeholder="Father's Last Name" required>
            <?php if (isset($errors['father_last_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['father_last_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="father_first_name" value="<?php echo htmlspecialchars($data['father_first_name']); ?>" placeholder="Father's First Name" required>
            <?php if (isset($errors['father_first_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['father_first_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="father_middle_name" value="<?php echo htmlspecialchars($data['father_middle_name']); ?>" placeholder="Father's Middle Name">

            <input type="text" name="mother_last_name" value="<?php echo htmlspecialchars($data['mother_last_name']); ?>" placeholder="Mother's Last Name" required>
            <?php if (isset($errors['mother_last_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['mother_last_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="mother_first_name" value="<?php echo htmlspecialchars($data['mother_first_name']); ?>" placeholder="Mother's First Name" required>
            <?php if (isset($errors['mother_first_name'])): ?>
                <div class='error'><?php echo htmlspecialchars($errors['mother_first_name']); ?></div>
            <?php endif; ?>

            <input type="text" name="mother_middle_name" value="<?php echo htmlspecialchars($data['mother_middle_name']); ?>" placeholder="Mother's Middle Name">

            <button type="submit">Update</button>
        </form>
    </div>

    <script>
    // Function to toggle the visibility of the "Other Civil Status" input
        function toggleOtherCivilStatus() {
            var civilStatusSelect = document.getElementById('civil_status');
            var otherCivilStatusInput = document.getElementById('other_civil_status');
            
            if (civilStatusSelect.value === 'Other') {
                otherCivilStatusInput.style.display = 'block';
            } else {
                otherCivilStatusInput.style.display = 'none';
                otherCivilStatusInput.value = ''; // Clear the input if not selected
            }
        }

        // Add event listener to the civil status dropdown
        document.getElementById('civil_status').addEventListener('change', toggleOtherCivilStatus);

        // Check the initial value of the civil status dropdown on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleOtherCivilStatus(); // Call the function to set the initial state
        });
    </script>
</body>
</html>