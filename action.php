<?php
    session_start();
    include 'config.php';

    $update = false;
    $id = "";
    $name = "";
    $genre = "";
    $rating = "";
    $status = "";
    $comments = "";
    $image = "";

    // Add item to database
    if(isset($_POST['add'])) {
        $table = $_POST['table'];
        $table_name = $_POST['newtable'];
        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $rating = $_POST['rating'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];

        $image = basename($_FILES['image']['name']);
        $img_dir = 'uploads/';
        $img_file = $img_dir . basename($_FILES['image']['name']);

        if($table == 'new') {
            createTable($table_name);
            $query = 'INSERT INTO '.$table_name.'(Photo,Name,Genre,Rating,Status,Comments)VALUES(?,?,?,?,?,?)';
        } else {
            $query = 'INSERT INTO '.$table.'(Photo,Name,Genre,Rating,Status,Comments)VALUES(?,?,?,?,?,?)';
        }

        $statement = $conn->prepare($query);
        $statement->bind_param('ssssss', $img_file, $name, $genre, $rating, $status, $comments);
        $statement->execute();
        move_uploaded_file($_FILES['image']['tmp_name'], $img_file);

        header('location:index.php');
        $_SESSION['response'] = 'Successfully added item!';
        $_SESSION['response_type'] = 'success';
    }

    // Delete item from database
    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = 'SELECT Photo FROM anime WHERE ID=?';
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row = $result2->fetch_assoc();

        $imagepath = $row['Photo'];
        unlink($imagepath);

        $query = 'DELETE FROM anime WHERE ID=?';
        $statement = $conn->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        header('location:database.php');
        $_SESSION['response'] = 'Successfully deleted item!';
        $_SESSION['response_type'] = 'danger';
    }

    // Get current item information
    if(isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $query = 'SELECT * FROM anime WHERE ID=?';
        $statement = $conn->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        $id = $row['ID'];
        $name = $row['Name'];
        $genre = $row['Genre'];
        $rating = $row['Rating'];
        $status = $row['Status'];
        $comments = $row['Comments'];
        $image = $row['Photo'];
        
        $update = true;
    }

    // Update item information
    if(isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $genre = $_POST['genre'];
        $rating = $_POST['rating'];
        $status = $_POST['status'];
        $comments = $_POST['comments'];
        $old_img = $_POST['old-img'];

        if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
            $new_img = 'uploads/'.basename($_FILES['image']['name']);
            unlink($old_img);
            move_uploaded_file($_FILES['image']['tmp_name'], $new_img);
        } else {
            $new_img = $old_img;
        }

        $query = 'UPDATE anime SET Photo=?, Name=?, Genre=?, Rating=?, Status=?, Comments=? WHERE ID=?';
        $statement = $conn->prepare($query);
        $statement->bind_param('ssssssi', $new_img, $name, $genre, $rating, $status, $comments, $id);
        $statement->execute();

        header('location:index.php');
        $_SESSION['response'] = 'Updated successfully!';
        $_SESSION['response_type'] = 'secondary';
    }

    // Get item information to display in modal 
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = 'SELECT * FROM anime WHERE ID=?';
        $statement = $conn->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        $vid = $row['ID'];
        $vname = $row['Name'];
        $vgenre = $row['Genre'];
        $vrating = $row['Rating'];
        $vstatus = $row['Status'];
        $vcomments = $row['Comments'];
        $vimage = $row['Photo'];
    }

    // Create new table in database
    function createTable($table_name) {
        $statement = 'CREATE TABLE '.$table_name;
        $statement .= '(ID int(11) AUTO_INCREMENT, Photo varchar(255) null, Name varchar(100) not null, Genre varchar(255) not null,';
        $statement .= ' Rating int(2) null, Status varchar(13) not null, Comments varchar(300) null, PRIMARY KEY (ID))';

        $result = mysqli_query($conn, $statement);

        header('location:index.php');
        $_SESSION['response'] = 'Successfully created new table!';
        $_SESSION['response_type'] = 'success';
    }
?>