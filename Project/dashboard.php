<?php
include "db.php";

if(! isset($_SESSION["uname"])){
    header("Location:login.php");
    exit();
}
$user_id=$_SESSION["id"];
$username=$_SESSION["uname"];

// fetch all blogs
$result=$conn->query("SELECT blogs.*, uname FROM blogs JOIN user ON blogs.user_id=user.id");

// separate user blogs & other blogs
$userBlogs = [];
$otherBlogs = [];
while($row=$result->fetch_assoc()){
    if($row["user_id"]==$user_id){
        $userBlogs[] = $row;
    } else {
        $otherBlogs[] = $row;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        body {
            background: linear-gradient(135deg, #000 40%, #4c0080 100%);
            min-height: 100vh;
            padding-top: 80px;
            color: #fff;
        }
        .navbar {
            background: #000 !important;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 6px 15px rgba(0,0,0,0.25);
            border: none;
            background: #fff;
            color: #000;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s ease forwards;
        }
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Full image but keep ratio */
        .card img {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            width: 100%;
            height: auto;
            object-fit: contain;
            background: #f8f9fa;
        }

        .btn-custom {
            border-radius: 20px;
            padding: 5px 15px;
        }
        .section-title {
            margin: 30px 0 20px;
            font-weight: bold;
            font-size: 1.6rem;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 5px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s ease forwards;
        }
        .welcome-text {
            font-size: 1.8rem;
            font-weight: bold;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s ease forwards;
            animation-delay: 0.2s;
        }
        .welcome-text span {
            color: violet;
        }
        footer {
            background: rgba(0,0,0,0.9);
            color: #aaa;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">Blogs</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <form class="d-flex ms-auto me-3">
                    <input class="form-control me-2" type="search" placeholder="Search blogs..." aria-label="Search">
                    <button class="btn btn-light btn-sm" type="submit">Search</button>
                </form>

                <a class="btn btn-warning btn-custom me-2" href="addblog.php">Add Blog</a>
                <a class="btn btn-danger btn-custom" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
</header>

<main class="container">

    <!-- Welcome message -->
    <div class="text-center mb-4 welcome-text">
        Welcome..! <span><?= ucfirst($username) ?></span>
    </div>

    <!-- Your Blogs Section -->
    <?php if(!empty($userBlogs)) { ?>
        <div class="section-title">Your Blogs</div>
        <div class="row">
            <?php foreach($userBlogs as $row) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="uploads/<?= $row["image"] ?>" alt="<?= $row["title"] ?>">
                        <div class="card-body">
                            <small>By: <?= $row["uname"] ?> | <?= $row["created_at"]?></small>
                            <h4 class="card-title"><?= $row["title"]?></h4>
                            <p class="card-text"><?= $row["content"]?></p>
                        </div>
                        <div class="card-footer text-center">
                            <a class="btn btn-primary btn-sm me-2" href="editblog.php?id=<?= $row["id"]?>" role="button">Edit</a>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?')" href="delete.php?id=<?= $row["id"]?>" role="button">Delete</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <!-- Other Blogs Section -->
    <?php if(!empty($otherBlogs)) { ?>
        <div class="section-title">Other Blohttps://github.com/HarsHMestrY/bhavik.gitgs</div>
        <div class="row">
            <?php foreach($otherBlogs as $row) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="uploads/<?= $row["image"] ?>" alt="<?= $row["title"] ?>">
                        <div class="card-body">
                            <small>By: <?= $row["uname"] ?> | <?= $row["created_at"]?></small>
                            <h4 class="card-title"><?= $row["title"]?></h4>
                            <p class="card-text"><?= $row["content"]?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

</main>

<footer class="text-center py-3">
    <p class="mb-0">© <?= date("Y") ?> Blog Dashboard. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
