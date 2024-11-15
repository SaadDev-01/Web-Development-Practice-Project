<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "login";

$message = '';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signup'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        if (strlen($user) < 3) {
            $message = "Username must be at least 3 characters long.";
        } elseif (strlen($pass) < 6) {
            $message = "Password must be at least 6 characters long.";
        } else {
            $stmt = $conn->prepare("SELECT username FROM login WHERE username = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $message = "Username already exists.";
            } else {
                $pass_hashed = password_hash($pass, PASSWORD_DEFAULT); 
                $stmt->close();
                
                $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $user, $pass_hashed);
                
                if ($stmt->execute()) {
                    $message = "Signup successful!";
                } else {
                    $message = "Error: " . $stmt->error;
                }
            }
            $stmt->close();
        }
    }

    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (password_verify($pass, $hashed_password)) {
                $_SESSION["username"] = $user;

                header("Location: /LOGINSIGNUP/index.php");
                exit();
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "No user found.";
        }

        $stmt->close();
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup Form</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .container:hover { 
            transform: translateY(-5px); 
        }
        h2 {
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
            font-size: 24px;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #0072ff;
            border-radius: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #0072ff;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover { background: #00c6ff; }
        .message {
            color: #d9534f;
            margin: 15px 0;
            font-size: 14px;
        }
        .toggle {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }
        .toggle a { 
            color: #0072ff; 
            text-decoration: none; 
            font-weight: bold; }
        .form-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .active { 
            display: block; 
            opacity: 1; }
        @media (max-width: 480px) {
            .container { width: 90%; padding: 20px; 
            }
        }
        </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION["username"])): ?>
            <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]); ?>!</h2>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        <?php else: ?>
            <div class="form-section active" id="loginForm">
                <h2>Login</h2>
                <form method="post">
                    <input type="text" name="username" required placeholder="Username">
                    <input type="password" name="password" required placeholder="Password">
                    <input type="submit" name="login" value="Login">
                </form>
                <div class="toggle">
                    <p>Don't have an account?</p>
                    <a href="#" id="showSignup">Signup</a>
                </div>
            </div>

            <div class="form-section" id="signupForm">
                <h2>Signup</h2>
                <form method="post">
                    <input type="text" name="username" required placeholder="Username">
                    <input type="password" name="password" required placeholder="Password">
                    <input type="submit" name="signup" value="Signup">
                </form>
                <div class="toggle">
                    <p>Already have an account?</p>
                    <a href="#" id="showLogin">Login</a>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="message"><?= htmlspecialchars($message); ?></div>
    </div>

    <script>
        document.getElementById('showSignup').onclick = function() {
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById('signupForm').classList.add('active');
        };

        document.getElementById('showLogin').onclick = function() {
            document.getElementById('signupForm').classList.remove('active');
            document.getElementById('loginForm').classList.add('active');
        };
    </script>
</body>
</html>