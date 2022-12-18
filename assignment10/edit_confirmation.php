<?php
require "config/config.php";
$isUpdated = false;

if (!isset($_POST["title"]) || empty($_POST["title"])) {
    $error = "Please fill out all required fields.";
} else {
    $mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    // var_dump($_POST);

    $title =  $_POST["title"];
    $id = $_POST["dvd_id"];

    // Handling optional fields
    if (isset($_POST["release_date"]) && !empty($_POST["release_date"])) {
        $date = date('Y-m-d', strtotime($_POST["release_date"]));
    } else {
        $date = null;
    }

    if (isset($_POST["label"]) && !empty($_POST["label"])) {
        $label = $_POST["label"];
    } else {
        $label = null;
    }

    if (isset($_POST["sound"]) && !empty($_POST["sound"])) {
        $sound = $_POST["sound"];
    } else {
        $sound = null;
    }

    if (isset($_POST["genre"]) && !empty($_POST["genre"])) {
        $genre = $_POST["genre"];
    } else {
        $genre = null;
    }

    if (isset($_POST["rating"]) && !empty($_POST["rating"])) {
        $rating = $_POST["rating"];
    } else {
        $rating = null;
    }

    if (isset($_POST["format"]) && !empty($_POST["format"])) {
        $format = $_POST["format"];
    } else {
        $format = null;
    }

    if (isset($_POST["award"]) && !empty($_POST["award"])) {
        $award = "'" . $_POST["award"] . "'";
    } else {
        $award = null;
    }

    // May have to check how the string is formatted. Keep an eye on this

    $statement = $mysqli->prepare("UPDATE dvd_titles SET title = ?, release_date = ?, award = ?, label_id = ?, sound_id = ?, genre_id = ?, rating_id = ?, format_id = ? WHERE dvd_title_id = ?");

    $statement->bind_param("sssiiiiii", $title, $date, $award, $label, $sound, $genre, $rating, $format, $id);

    $executed = $statement->execute();
    if (!$executed) {
        echo "Not executed!";
        echo "</br>";
        echo $mysqli->error;
        echo "</br>";
    }

    if ($statement->affected_rows == 1) {
        $isUpdated = true;
    } else {
        echo "Uh oh! Affected rows: ";
        echo $statement->affected_rows;
        echo " Id: $id";
    }

    $statement->close();

    $mysqli->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Confirmation | DVD Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
        <li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
        <li class="breadcrumb-item"><a href="details.php">Details</a></li>
        <li class="breadcrumb-item"><a href="edit_form.php">Edit</a></li>
        <li class="breadcrumb-item active">Confirmation</li>
    </ol>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4">Edit a DVD</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">

                <?php if (isset($error) && !empty($error)) : ?>
                <div class="text-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <?php if ($isUpdated) : ?>
                <div class="text-success">
                    <span class="font-italic"><?php echo $_POST["title"]; ?></span> was successfully edited.
                </div>
                <?php endif; ?>

            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="details.php?dvd_id=<?php echo $_POST["dvd_id"]; ?>" role="button" class="btn btn-primary">Back
                    to Details</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</body>

</html>