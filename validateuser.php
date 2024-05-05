<?php
    session_start();
    $conn = mysqli_connect("localhost","root","","login");

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      // Check if form is submitted for registration
      if (isset($_POST['register'])) {
        // Get registration data
        $username = $_POST["username"];
        $password = $_POST["password"];
      
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      
        // Insert user data into database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
      
        if ($conn->query($sql) === TRUE) {
          // Registration successful
          echo "Registration successful! Please login to access.";
        } else {
          // Registration failed
          echo "Registration failed: " . $conn->error;
        }
      } else { // Check for login attempt
        // Login data (already defined from form submission)
        $username = $_POST["username"];
        $password = $_POST["password"];
      
        // Validate login credentials
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);
      
        if ($result->num_rows > 0) {
          // Login successful
          $_SESSION["IsLogin"] = true;
          header("Location: index.php");
        } else {
          // Login failed
          header("Location: login.html");
        }
      }
      
      $conn->close();
      ?>