<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uname = $_POST["uname"];
    $email = $_POST["email"];
    $pass = password_hash($_POST["pass"], PASSWORD_BCRYPT);

    $sql = $conn->prepare("INSERT INTO user (uname,email,pass) VALUES (?,?,?)");
    $sql->bind_param("sss", $uname, $email, $pass);
    if ($sql->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Database Error: " . $sql->error;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
       body {
    background: linear-gradient(135deg, #000000, #2e003e);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
    font-family: 'Poppins', sans-serif;
}
.form-box {
    background: #111;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0px 6px 20px rgba(138, 43, 226, 0.7);
    width: 450px;
    animation: fadeIn 0.8s ease-in-out;
}
.form-box h3 {
    color: violet;
    font-weight: bold;
    text-shadow: 0 0 10px violet;
}
.form-control {
    background: #222;
    border: 1px solid #444;
    color: #fff;
}
.form-control:focus {
    background: #222;
    color: #fff;
    border-color: violet;
    box-shadow: 0 0 8px violet;
}
.btn-custom {
    background: violet;
    border: none;
    color: black;
    font-weight: bold;
    transition: 0.3s;
}
.btn-custom:hover {
    background: #9400d3;
    color: #fff;
    box-shadow: 0 0 15px violet;
}
a {
    color: violet;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
    color: #fff;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

    </style>
</head>
<body>
    <div class="form-box">
        <h3>Create Account</h3>
        <form method="post">
            <div class="mb-3 text-start">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="uname" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Register</button>
            <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
