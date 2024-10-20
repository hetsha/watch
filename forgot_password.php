<?php
session_start();
require_once "include/db.php";

// Flag to check if the email exists
$emailExists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['check_email'])) {
        $email = $_POST['email'];

        // Check if the email exists in the customers table
        $query = "SELECT * FROM customers WHERE customer_email = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $emailExists = true; // Email found in customers table
                $_SESSION['reset_email'] = $email; // Store email in session
            } else {
                // If not found in customers, check the admins table
                $query = "SELECT * FROM admins WHERE admin_email = ?";
                if ($stmt = $con->prepare($query)) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $emailExists = true; // Email found in admins table
                        $_SESSION['reset_email'] = $email; // Store email in session
                    }
                }
            }

            if (!$emailExists) {
                echo "<script>alert('Email not found. Please try another one.');</script>";
            }
            $stmt->close();
        }
    } elseif (isset($_POST['reset_password'])) {
        $new_password = $_POST['new_password'];
        $email = $_SESSION['reset_email']; // Get the email from session

        // Update password in customers table if it exists
        $query = "UPDATE customers SET customer_pass = ? WHERE customer_email = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();
            $stmt->close();
        }

        // Update password in admins table if it exists
        $query = "UPDATE admins SET admin_pass = ? WHERE admin_email = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("ss", $new_password, $email);
            $stmt->execute();
            $stmt->close();
        }

        // Clear the session variable
        unset($_SESSION['reset_email']);

        echo "<script>alert('Your password has been reset successfully.'); window.location.href='login.php';</script>";
        exit;
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/img/favicon.png" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Password Reset</title>
</head>
<body>
    <div class="bg-light py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <div class="row gy-3 mb-5">
                            <div class="col-12">
                                <div class="text-center">
                                    <a href="#!">
                                        <img src="./assets/img/light-logo.png" alt="BootstrapBrain Logo" width="175" height="57">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12">
                                <h2 class="fs-6 fw-normal text-center text-secondary m-0 px-md-5">
                                    <?php if (!$emailExists): ?>
                                        Provide the email address associated with your account to recover your password.
                                    <?php else: ?>
                                        Enter a new password for your account.
                                    <?php endif; ?>
                                </h2>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <?php if (!$emailExists): ?>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                </svg>
                                            </span>
                                            <input type="email" class="form-control" name="email" id="email" required>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-12">
                                        <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit" name="<?php echo $emailExists ? 'reset_password' : 'check_email'; ?>">
                                            <?php echo $emailExists ? 'Reset Password' : 'Check Email'; ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="d-flex gap-4 justify-content-center">
                                    <a href="login.php" class="link-secondary text-decoration-none">Log In</a>
                                    <a href="login.php?action=register" class="link-secondary text-decoration-none">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
