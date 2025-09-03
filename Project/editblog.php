<?php
include "db.php";

if (!isset($_SESSION["uname"])) {
    header("Location: login.php");
    exit();
}

$id = (int) $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title   = $_POST["title"];
    $content = $_POST["content"];
    $image   = $_POST["image_url"]; 

    if (!empty($_FILES["image"]["name"])) {
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target = "uploads/" . $filename;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
        $image = $filename;
    }

    $stmt = $conn->prepare("UPDATE blogs SET title=?, content=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $content, $image, $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM blogs WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$blog = $stmt->get_result()->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Edit Blog</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #000000, #2c003e, #5e17eb);
            background-size: 300% 300%;
            animation: gradientBG 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-box {
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(94, 23, 235, 0.7);
            width: 500px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-box h3 {
            text-align: center;
            margin-bottom: 20px;
            color: violet;
        }

        .btn-custom {
            background: violet;
            color: black;
            font-weight: bold;
            border: none;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: #5e17eb;
            color: white;
        }

        .form-control {
            background: #1a1a1a;
            color: white;
            border: 1px solid violet;
        }

        .form-control:focus {
            box-shadow: 0 0 10px violet;
            border-color: violet;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h3>Edit Blog</h3>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= $blog['title'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="5" required><?= $blog['content'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-custom">Update Blog</button>
            </div>
        </form>
    </div>
</body>
</html>
