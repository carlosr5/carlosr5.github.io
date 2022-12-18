<?php
if (!isset($_GET["dvd_id"]) || empty($_GET["dvd_id"])) {
    // Create a variable and store error message
    $error = "Invalid track ID.";
} else {
    // 1) Establish DB connection
    // Store DB credentials
    $host = "303.itpwebdev.com";
    $user = "carlosr5_db_user";
    $password = "cherryCoke!";
    $db = "carlosr5_dvd_db";

    // Create instance of MySQLi class
    $mysqli = new MySQLi($host, $user, $password, $db);

    // Error handling
    if ($mysqli->connect_errno) {
        // Displaying error message
        echo $mysqli->connect_error;
        // PHP stops running
        exit();
    }

    $mysqli->set_charset("utf-8");

    $dvd_sql = "SELECT dvd_titles.title AS 'title', dvd_titles.release_date AS 'release-date', genres.genre AS 'genre', labels.label AS 'label',ratings.rating AS 'rating', sounds.sound AS 'sound', formats.format AS 'format', dvd_titles.award, dvd_titles.dvd_title_id AS 'id'
FROM dvd_titles
JOIN genres
    ON dvd_titles.genre_id = genres.genre_id
JOIN labels
	ON dvd_titles.label_id = labels.label_id
JOIN ratings
    ON dvd_titles.rating_id = ratings.rating_id
JOIN sounds
	ON dvd_titles.sound_id = sounds.sound_id
JOIN formats
	ON dvd_titles.format_id = formats.format_id
WHERE 1=1 AND dvd_titles.dvd_title_id = " . "'" . $_GET["dvd_id"] . "'";

    $results = $mysqli->query($dvd_sql);
    if (!$results) {
        echo $mysqli->error;
        exit();
    }

    $item = $results->fetch_assoc();

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Details | DVD Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
        <li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>

    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4">DVD Details</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->

    <div class="container">

        <div class="row mt-4">
            <div class="col-12">

                <?php if (isset($error) && !empty($error)) : ?>

                <div class="text-danger font-italic">
                    <?php echo $error; ?>
                </div>

                <?php else : ?>

                <table class="table table-responsive">

                    <tr>
                        <th class="text-right">Title:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["title"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Release Date:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["release-date"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Genre:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["genre"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Label:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["label"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Rating:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["rating"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Sound:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["sound"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Format:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["format"] ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="text-right">Award:</th>
                        <td>
                            <!-- PHP Output Here -->
                            <?php echo $item["award"] ?>
                        </td>
                    </tr>

                </table>
                <?php endif; ?>

            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
                <a href="edit_form.php?dvd_id=<?php echo trim($_GET["dvd_id"]); ?>" class="btn btn-warning">Edit This
                    DVD</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</body>

</html>