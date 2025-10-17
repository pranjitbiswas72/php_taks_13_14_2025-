<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container mt-5">
    <div class="card p-4 shadow-lg">
      <h3 class="text-center mb-3">Registration Form</h3>

      <form id="regForm" action="insert.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="mb-3">
          <label>Full Name</label>
          <input type="text" class="form-control" name="name" id="name" required>
          <p class="text-danger" id="nameError"></p>
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" name="email" id="email" required>
          <p class="text-danger" id="emailError"></p>
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
          <p class="text-danger" id="passwordError"></p>
        </div>

        <div class="mb-3">
          <label>Confirm Password</label>
          <input type="password" class="form-control" name="confirm" id="confirm" required>
          <p class="text-danger" id="confirmPass"></p>
        </div>

        <div class="mb-3">
          <label>Phone</label>
          <input type="text" class="form-control" name="phone" id="phone" required>
          <p class="text-danger" id="phoneError"></p>
        </div>
        <div class="mb-3">
          <label>Address</label>
          <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
          <p class="text-danger" id="addressError"></p>
        </div>
        <div class="mb-3">
          <label>Profile Image</label>
          <input type="file" class="form-control" name="file" id="image" accept=".jpg,.jpeg,.png" required>
          <p class="text-danger" id="imageError"></p>
        </div>
        <button class="btn btn-primary w-10" type="submit">Submite</button>
      </form>
    </div>
  </div>


  <script>
    function validateForm() {
      let valid = true;

      // Clear previous error messages
      document.querySelectorAll("p.text-danger").forEach(e => e.innerText = "");

      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const confirm = document.getElementById('confirm').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const address = document.getElementById('address').value.trim();
      const image = document.getElementById('image').value.trim();

      // Name validation
      if (!/^[A-Za-z\s]+$/.test(name)) {
        document.getElementById('nameError').innerText = 'Invalid Name. Please try again.';
        valid = false;
      }

      // Email validation
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').innerText = "Invalid email address.";
        valid = false;
      }

      // Password validation
      if (password.length < 6) {
        document.getElementById('passwordError').innerText = "Minimum password length is 6 characters.";
        valid = false;
      }

      // Confirm password validation
      if (password !== confirm) {
        document.getElementById('confirmPass').innerText = "Confirm password does not match.";
        valid = false;
      }

      // Phone number validation
      if (!/^\d{11}$/.test(phone)) {
        document.getElementById('phoneError').innerText = "Invalid phone number. Must be 11 digits.";
        valid = false;
      }

      // Address validation (cannot be empty)
      if (address.length === 0) {
        document.getElementById('addressError').innerText = "Address cannot be empty.";
        valid = false;
      }

      // Image validation (must be jpg, jpeg, png)
      if (image.length === 0) {
        document.getElementById('imageError').innerText = "Please select an image.";
        valid = false;
      } else if (!/\.(jpg|jpeg|png)$/i.test(image)) {
        document.getElementById('imageError').innerText = "Invalid image format. Allowed: jpg, jpeg, png.";
        valid = false;
      }
      return valid;
    }
  </script>


</body>

</html>

