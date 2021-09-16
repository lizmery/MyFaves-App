<?php
    include 'action.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFaves App</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap theme from Bootswatch -->
    <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand font-weight-bolder" href="#">MyFaves App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="database.php">Database</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid pb-5">
    <div class="row justify-content-center mt-2">
        <div class="col-md-10 mt-5 mb-3">
            <h1 class="text-center text-primary mt-5">My <span class="text-secondary">'Favorites'</span> App</h1>
            <?php
                if(isset($_SESSION['response'])) {
            ?>
            <div class="alert alert-<?= $_SESSION['response_type']; ?> alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['response']; ?>
            </div>
        <?php } unset($_SESSION['response']); ?>
        </div>
    </div>
    <div class="mx-3">
        <form action="action.php" method="post" enctype="multipart/form-data" class="shadow p-5 mx-3 bg-white rounded">
            <div class="form-group">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <?php
                    $query = 'SHOW TABLES FROM '.$cleardb_db;
                    $statement = $conn->prepare($query);
                    $statement->execute();
                    $result = $statement->get_result();
                ?>
                <label for="table" class="form-label mt-4">Select Table:</label>
                <select class="form-select" id="table" name="table" onchange="showInput(this)">
                    <?php 
                        while ($row = $result->fetch_assoc()) {
                            foreach ($row as $r) { 
                    ?>
                    <option value="<?= $r; ?>" id="<?= $r; ?>"><?= $r; ?></option>
                    <?php } } ?>
                    <option value="new" id="new">New</option>
                </select>
            </div>
            <div class="form-group" style="display: none;" id="new-input">
                <label for="newtable" class="form-label mt-2 text-secondary">Create New Table:</label>
                <input type="text" class="form-control" id="newtable" name="newtable"  placeholder="Enter new table name">
            </div>
            <div class="form-group">
                <label for="name" class="form-label mt-2">Item Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $name; ?>" placeholder="Enter item name" required>
            </div>
            <div class="form-group">
                <label for="genre" class="form-label mt-2">Genre(s):</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= $genre; ?>" placeholder="Enter item genre(s)" required>
            </div>
            <div class="form-group">
                <label for="rating" class="form-label mt-2">Rating:</label>
                <input type="number" class="form-control" id="rating" name="rating" value="<?= $rating; ?>" placeholder="Enter a number (1-10)" required>
            </div>
            <div class="form-group">
                <label for="" class="form-label mt-2">Status:</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="status" value="Completed" required>
                        Completed
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="status" value="Not Completed">
                        Not Completed
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="comments" class="form-label mt-2">Comments:</label>
                <?php if($update == true) { ?>
                    <textarea class="form-control" id="comments" name="comments" rows="3"><?= $comments; ?></textarea>
                <?php } else { ?>
                    <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="image" class="form-label mt-2">Upload Image</label>
                <input type="hidden" name="old-img" value="<?= $image; ?>">
                <input class="form-control custom-file" type="file" id="image" name="image">
                <img src="<?= $image; ?>" width="120" class="img-thumbnail">
            </div>
            <div class="form-group mt-5">
                <?php if($update == true) { ?>
                    <button type="submit" class="btn btn-block btn-outline-secondary btn-lg" name="update">Update Item</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-block btn-primary btn-lg" name="add">Add Item</button>
                    <a href="database.php" class="btn btn-block btn-outline-secondary btn-lg">View Items</a>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>