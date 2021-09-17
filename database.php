<?php
    include 'action.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFaves App | Database</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap theme from Bootswatch -->
    <link rel="stylesheet" href="bootstrap.min.css">
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
    <div class="row justify-content-center">
        <div class="col-md-10 mt-5">
            <h1 class="text-center text-primary mt-5">A Database For All of Your Favorites!</h1>
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
</div>

<div id="accordion" class="accordion">
    <?php
        $query = 'SHOW TABLES FROM '.$cleardb_db;
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
    ?>
    <?php 
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $r) { 
    ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-<?= $r; ?>">
            <button class="accordion-button" type="button" data-toggle="collapse" data-target="#<?= $r; ?>" aria-expanded="true" aria-controls="<?= $r; ?>">
                <h4 class="text-capitalize"><?= $r; ?></h4>
            </button>
        </h2>
        <div id="<?= $r; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $r; ?>" data-parent="#accordion">
            <div class="accordion-body">
                <div class="container-fluid mt-5 mb-5">
                    <h2 class="text-center mb-5 text-capitalize">favorite <?= $r; ?><span class="text-lowercase">(s)</span></h2>
                    <?php
                        $new_query = 'SELECT * FROM '.$r;
                        $new_statement = $conn->prepare($new_query);
                        $new_statement->execute();
                        $new_result = $new_statement->get_result();
                    ?>
                    <table class="table table-striped table-responsive-lg">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($new_row = $new_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $new_row['ID']; ?></td>
                                <td><img src="<?= $new_row['Photo']; ?>" width="30" height="30"></td>
                                <td><?= $new_row['Name']; ?></td>
                                <td><?= $new_row['Genre']; ?></td>
                                <td><?= $new_row['Rating']; ?></td>
                                <td><?= $new_row['Status']; ?></td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#myModal" data-id="<?= $new_row['ID']; ?>" id="details">Details</a> 
                                    <a href="index.php?edit=<?= $new_row['ID']; ?>" class="btn btn-success btn-sm mr-1">Edit</a>
                                    <a href="action.php?delete=<?= $new_row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>
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