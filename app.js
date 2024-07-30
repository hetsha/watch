function validateForm() {
  const namePattern = /^[a-zA-Z\s]+$/;
  const mobilePattern = /^\d{10}$/;
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const passwordPattern =
    /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[\W_]).{8,}$/;

  // Retrieve input field values
  const fullname = document.getElementById("user").value.trim();
  const mobile = document.getElementById("num").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("pass").value.trim();

  // Check if any field is empty
  if (fullname === "" || mobile === "" || email === "" || password === "") {
    showAlertPopup("Please fill out all fields.");
    return false;
  }

  // Validate Full Name
  if (!fullname.match(namePattern)) {
    showAlertPopup("Please enter a valid full name.");
    return false;
  }

  // Validate Mobile Number
  if (!mobile.match(mobilePattern)) {
    showAlertPopup("Please enter a valid mobile number.");
    return false;
  }

  // Validate Email
  if (!email.match(emailPattern)) {
    showAlertPopup("Please enter a valid email address.");
    return false;
  }

  // Validate Password
  if (!password.match(passwordPattern)) {
    showAlertPopup(
      "Password must be at least 8 characters long and contain at least one digit, one lowercase letter, one uppercase letter, and one special character"
    );
    return false;
  }

  // If all validations pass, submit the form
  showAlertPopup("All fields are valid.");
  return true;
}

function showAlertPopup(message) {
  const popup = document.createElement("div");
  popup.className = "popup";
  popup.textContent = message;
  document.body.appendChild(popup);

  // Remove the popup after some time (e.g., 3 seconds)
  setTimeout(() => {
    popup.remove();
  }, 3000);
}

function validform() {
  const namePattern = /^[a-zA-Z\s]+$/;
  const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;

  // Retrieve input field values
  const fullname = document.getElementById("user").value.trim();
  const password = document.getElementById("pass").value.trim();

  // Check if any field is empty
  if (fullname === "" || password === "") {
    showAlertPopup("Please fill out all fields.");
    return false;
  }

  // Validate Full Name
  if (!fullname.match(namePattern)) {
    showAlertPopup("Please enter a valid full name.");
    return false;
  }

  // Validate Password
  if (!password.match(passwordPattern)) {
    showAlertPopup(
      "Password must be at least 8 characters long and contain at least one digit, one lowercase letter, one uppercase letter, and one special character"
    );
    return false;
  }

  // If all validations pass, submit the form
  showAlertPopup("All fields are valid.");
  return true;
}

function showAlertPopup(message) {
  const popup = document.createElement("div");
  popup.className = "popup";
  popup.textContent = message;
  document.body.appendChild(popup);

  // Remove the popup after some time (e.g., 3 seconds)
  setTimeout(() => {
    popup.remove();
  }, 3000);
}
