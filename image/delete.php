<?php
include '../controller/usercontroller.php';


if (isset($_GET['email'])) {
    $email = $_GET['email']; 

    // Instantiate the controller
    $controller = new UserController();

    // Call the deleteUser method to delete by email
    if ($controller->deleteUser($email)) {
        // Redirect to the user list after successful deletion
        header("Location:../view/list.php");
        exit();
    } else {
        echo "Error: Could not delete the user.";
    }
} else {
    echo "Error: No user email specified.";
}
?>
