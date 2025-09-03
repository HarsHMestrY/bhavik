<?php 
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title   = $_POST["title"];
    $content = $_POST["content"];
    $image_name = $_FILES["image"]["name"]; 
    $user_id = $_SESSION["id"];
    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/$image_name");

    $sql = $conn->prepare("INSERT INTO blogs(title,content,image,user_id) VALUES (?,?,?,?)");
    $sql->bind_param("sssi", $title, $content, $image_name, $user_id);
    $sql->execute();

    header("Location: dashboard.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Add Blog</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f0f0f, #4b0082); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.5);
            width: 650px;
            backdrop-filter: blur(10px);
            color: #fff;
            animation: fadeInUp 1s ease-in-out;
        }
        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: violet;
        }
        .form-control {
            background: rgba(255,255,255,0.2);
            border: none;
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.3);
            color: #fff;
            box-shadow: none;
        }
        label {
            font-weight: 500;
            color: #ddd;
        }
        .btn-custom {
            background: violet;
            border: none;
            color: black;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background: #ff66ff;
            transform: scale(1.05);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<main>
    <div class="form-box">
        <h2>Add Blog</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" name="content" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Choose file</label>
                <input type="file" class="form-control" name="image" />
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="dashboard.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-custom">Submit</button>
            </div>
        </form>
    </div>
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
