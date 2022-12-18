<?php
require "config/config.php";
$isInserted = false;

if (!isset($_POST["title"]) || empty($_POST["title"])) {
    $error = "Please fill out all required fields.";
} else {
    $mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $title =  "'" . $_POST["title"] . "'";

    // Handling optional fields
    if (isset($_POST["release_date"]) && !empty($_POST["release_date"])) {
        $date = "'" . $_POST["release_date"] . "'";
    } else {
        $date = "null";
    }

    if (isset($_POST["label_id"]) && !empty($_POST["label_id"])) {
        $label = $_POST["label_id"];
    } else {
        $label = "null";
    }

    if (isset($_POST["sound_id"]) && !empty($_POST["sound_id"])) {
        $sound = $_POST["sound_id"];
    } else {
        $sound = "null";
    }

    if (isset($_POST["genre_id"]) && !empty($_POST["genre_id"])) {
        $genre = $_POST["genre_id"];
    } else {
        $genre = "null";
    }

    if (isset($_POST["rating_id"]) && !empty($_POST["rating_id"])) {
        $rating = $_POST["rating_id"];
    } else {
        $rating = "null";
    }

    if (isset($_POST["format_id"]) && !empty($_POST["format_id"])) {
        $format = $_POST["format_id"];
    } else {
        $format = "null";
    }

    if (isset($_POST["award"]) && !empty($_POST["award"])) {
        $award = "'" . $_POST["award"] . "'";
    } else {
        $award = "null";
    }

    // May have to check how the string is formatted. Keep an eye on this
    $sql = "INSERT INTO dvd_titles(title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
    VALUES($title, $date, $award, $label, $sound, $genre, $rating, $format);";

    $results = $mysqli->query($sql);
    if (!$results) {
        echo $mysqli->error;
        exit();
    }

    if ($mysqli->affected_rows == 1) {
        $isInserted = true;
    }

    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Confirmation | DVD Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
        <li class="breadcrumb-item active">Confirmation</li>
    </ol>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4">Add a DVD</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">

                <?php if (isset($error) && !empty($error)) : ?>
                <div class="text-danger font-italic"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($isInserted) : ?>
                <div class="text-success"><span class="font-italic"><?php echo $_POST["title"]; ?></span> was
                    successfully added.
                </div>
                <?php endif; ?>

            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</body>

</html>