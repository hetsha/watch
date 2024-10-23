<?php
session_start(); // Ensure this is the very first line in your PHP script
require_once "include/db.php";

// Check for cookies and set session variables accordingly
if (isset($_COOKIE['customer_name'])) {
    $username = $_COOKIE['customer_name'];

    // Check the customers table
    $query = "SELECT * FROM customers WHERE customer_name = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // User found in customers table
            $customer = $result->fetch_assoc();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['customer_name'] = $username;
            $_SESSION['customer_email'] = $customer['customer_email'];
            $_SESSION['customer_pass'] = $customer['customer_pass']; // Changed to use customer_pass
            $_SESSION['customer_id'] = $customer['customer_id'];

            header("Location: index.php"); // Redirect to the main page
            exit;
        }

    }
}

if (isset($_COOKIE['admin_name'])) {
    $username = $_COOKIE['admin_name'];

    // Check the admins table
    $query = "SELECT * FROM admins WHERE admin_name = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // User found in admins table
            $user = $result->fetch_assoc();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['admin_name'] = $username;
            $_SESSION['admin_email'] = $user['admin_email'];
            $_SESSION['admin_pass'] = $user['admin_pass']; // Changed to use admin_pass

            header("Location: admin/index.php?dashboard"); // Redirect to admin dashboard
            exit;
        }

    }
}

// Continue with your existing login and signup logic
$mode = isset($_GET['action']) && $_GET['action'] === 'register' ? 'sign-up-mode' : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Handle signup logic (as before)
        $username = $_POST['signup_username'];
        $email = $_POST['signup_email'];
        $number = $_POST['signup_number'];
        $country = $_POST['signup_country'];
        $password = $_POST['signup_password'];
        $confirm_password = $_POST['signup_confirm_password'];

        // Check if username or email already exists
        $checkQuery = "SELECT * FROM customers WHERE customer_name = ? OR customer_email = ?";
        if ($stmt = $con->prepare($checkQuery)) {
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Username or email already exists
                echo "<script>alert('Username or email already exists!');</script>";
            } else {
                if ($password === $confirm_password) {
                    // Insert the new customer into the customers table
                    $query = "INSERT INTO customers (customer_name, customer_email, customer_contact, customer_country, customer_pass) VALUES (?, ?, ?, ?, ?)";
                    if ($stmt = $con->prepare($query)) {
                        $stmt->bind_param("sssss", $username, $email, $number, $country, $password);
                        $stmt->execute();
                        $customer_id = $con->insert_id;
                        $_SESSION['customer_id'] = $customer_id;
                        $_SESSION['cart'] = array();
                        echo "<script>alert('Registration successful!');</script>";

                    }
                } else {
                    echo "<script>alert('Passwords do not match!');</script>";
                }
            }
            //
        }
    } elseif (isset($_POST['login'])) {
        // Handle login logic (as before)
        $username = $_POST["username"];
        $password = $_POST["password"];

        // First, check in the admins table
        $query = "SELECT * FROM admins WHERE admin_name = ? AND admin_pass = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // User found in admins table
                $user = $result->fetch_assoc();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['admin_name'] = $username;
                $_SESSION['admin_email'] = $user['admin_email'];
                $_SESSION['admin_pass'] = $password;

                // Set cookie for admin login
                setcookie("admin_name", $username, time() + (86400 * 30), "/"); // 30 days

                header("Location: admin/index.php?dashboard");
                exit;
            }

        }

        // If not found in admins, check in the customers table
        $query = "SELECT * FROM customers WHERE customer_name = ? AND customer_pass = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // User found in customers table
                $customer = $result->fetch_assoc();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['customer_name'] = $username;
                $_SESSION['customer_email'] = $customer['customer_email'];
                $_SESSION['customer_pass'] = $password;
                $_SESSION['customer_id'] = $customer['customer_id'];

                // Set cookie for customer login
                setcookie("customer_name", $username, time() + (86400 * 30), "/"); // 30 days

                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Invalid Username or Password!');</script>";
            }

        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login / Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/log.css" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="stylesheet" href="assets/css/fontawesome-free-6.4.0-web/css/all.min.css">
</head>
<style>
    .forgot-password {
        display: block;
        margin-top: 10px;
        text-align: right;
        font-size: 14px;
        color: #3498db;
        text-decoration: none;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }
    /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000;
    left: -42%;
    bottom: -44%;
    width: 100%;
    height: 100%;
    /* background-color: rgba(0, 0, 0, 0.5); Black background with opacity */
    justify-content: center;
    align-items: center;
}

/* Modal Content */
.modal-content {
    background-color: #3498db;
    padding: 20px;
    color: white;
    border-radius: 5px;
    text-align: center;
    width: 300px;
    margin: auto;
}

/* Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 24px;
    cursor: pointer;
}

</style>

<body>
    <div class="container <?php echo $mode; ?>">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Sign In Form -->
                <form id="loginForm" action="" method="POST" class="sign-in-form">
                    <h2 class="title">Log In</h2>
                    <div class="input-field">
                        <i class="fas fa-user fa-2x"></i>
                        <input type="text" placeholder="Username" id="loginUser" name="username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock fa-2x"></i>
                        <input type="password" placeholder="Password" id="loginPass" name="password" required />
                    </div>
                    <input type="submit" value="Login" class="btn solid" name="login" />
                    <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                </form>
                <!-- Sign Up Form -->
                <form id="signupForm" action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign Up</h2>
                    <div class="input-field">
                        <i class="fas fa-user-plus fa-2x"></i>
                        <input type="text" placeholder="Username" id="signupUser" name="signup_username" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope fa-2x"></i>
                        <input type="email" placeholder="Email" id="signupEmail" name="signup_email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone fa-2x"></i>
                        <input type="text" placeholder="Number" id="signupNumber" name="signup_number" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-globe fa-2x"></i>
                        <input type="text" placeholder="Country" id="signupCountry" name="signup_country" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock fa-2x"></i>
                        <input type="password" placeholder="Password" id="signupPass" name="signup_password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock fa-2x"></i>
                        <input type="password" placeholder="Confirm Password" id="signupConfirmPass" name="signup_confirm_password" required />
                    </div>
                    <input type="submit" value="Sign Up" class="btn solid" name="signup" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google fa-lg"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio minus natus est.</p>
                    <button class="btn transparent" id="sign-up-btn">
                        <i class="fas fa-user-plus fa-lg"></i> Sign Up
                    </button>
                </div>
                <img src="./assets/img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio minus natus est.</p>
                    <button class="btn transparent" id="sign-in-btn">
                        <i class="fas fa-sign-in-alt fa-lg"></i> Sign In
                    </button>
                </div>
                <img src="./assets/img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    <div id="popupModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modalMessage"></p>
    </div>
</div>

    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        if ("<?php echo $mode; ?>" === "sign-up-mode") {
            container.classList.add("sign-up-mode");
        }

        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function (e) {
    const username = document.getElementById('loginUser').value;
    const password = document.getElementById('loginPass').value;

    if (username === '' || password === '') {
        e.preventDefault();
        alert('Please fill in both fields');
    }
});

document.getElementById('signupForm').addEventListener('submit', function (e) {
    const username = document.getElementById('signupUser').value;
    const email = document.getElementById('signupEmail').value;
    const number = document.getElementById('signupNumber').value;
    const country = document.getElementById('signupCountry').value;
    const password = document.getElementById('signupPass').value;
    const confirmPassword = document.getElementById('signupConfirmPass').value;

    if (username === '' || email === '' || number === '' || country === '' || password === '' || confirmPassword === '') {
        e.preventDefault();
        showModal('Please fill in all fields');
    } else if (password !== confirmPassword) {
        e.preventDefault();
        showModal('Passwords do not match');
    } else if (!validateEmail(email)) {
        e.preventDefault();
        showModal('Please enter a valid email');
    } else if (!validatePhoneNumber(number)) {
        e.preventDefault();
        showModal('Phone number must be exactly 10 digits');
    }
});

function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(String(email).toLowerCase());
}

function validatePhoneNumber(number) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(number);
}

function showModal(message) {
    const modal = document.getElementById('popupModal');
    const modalMessage = document.getElementById('modalMessage');
    const closeModal = document.getElementsByClassName('close')[0];

    modalMessage.textContent = message;
    modal.style.display = 'flex'; // Show the modal

    // Close the modal when clicking on the 'X' button
    closeModal.onclick = function () {
        modal.style.display = 'none';
    };

    // Close the modal when clicking outside of the modal content
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Automatically close the modal after 4 seconds (4000 ms)
    setTimeout(function () {
        modal.style.display = 'none';
    }, 3000);
}

    </script>
</body>
</html>
