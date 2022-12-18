<?php
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

// 2) Generate and submit sql queries
// Awards and release dates are from the dvd_titles. Otherwise we can bring everything else in
$titles_sql = "SELECT * FROM dvd_titles";
$genre_sql = "SELECT * FROM genres";
$rating_sql = "SELECT * FROM ratings";
$labels_sql = "SELECT * FROM labels";
$format_sql = "SELECT * FROM formats";
$sound_sql = "SELECT * FROM sounds";

// Submit query to DB. This should return info about results (gisves us an object)
$titles = $mysqli->query($titles_sql);
$genres = $mysqli->query($genre_sql);
$ratings = $mysqli->query($rating_sql);
$labels = $mysqli->query($labels_sql);
$formats = $mysqli->query($format_sql);
$sounds = $mysqli->query($sound_sql);

// Error handling. Results is false if there are errors
if (!$titles || !$genres || !$ratings || !$labels || !$formats || !$sounds) {
    echo $mysqli->error;
    exit();
}

$mysqli->close();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DVD Search Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    .form-check-label {
        padding-top: calc(.5rem - 1px * 2);
        padding-bottom: calc(.5rem - 1px * 2);
        margin-bottom: 0;
    }
    </style>
</head>

<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Search</li>
    </ol>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4 mb-4">DVD Search Form</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->
    <div class="container">
        <form action="search_results.php" method="GET">
            <div class="form-group row">
                <label for="title-id" class="col-sm-3 col-form-label text-sm-right">DVD Title:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="title-id" name="title">
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
                <div class="col-sm-9">
                    <select name="genre" id="genre-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <!-- Genre dropdown options here -->
                        <?php while ($genre = $genres->fetch_assoc()) : ?>
                        <option value="<?php echo $genre["genre_id"] ?>" ;>
                            <?php echo $genre["genre"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
                <div class="col-sm-9">
                    <select name="rating" id="rating-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <!-- Rating dropdown options here -->
                        <?php while ($rating = $ratings->fetch_assoc()) : ?>
                        <option value="<?php echo $rating["rating_id"] ?>">
                            <?php echo $rating["rating"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
                <div class="col-sm-9">
                    <select name="label" id="label-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <!-- Label dropdown options here -->
                        <?php while ($label = $labels->fetch_assoc()) : ?>
                        <option value="<?php echo $label["label_id"] ?>">
                            <?php echo $label["label"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
                <div class="col-sm-9">
                    <select name="format" id="format-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <!-- Format dropdown options here -->

                        <?php while ($format = $formats->fetch_assoc()) : ?>
                        <option value="<?php echo $format["format_id"] ?>">
                            <?php echo $format["format"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
                <div class="col-sm-9">
                    <select name="sound" id="sound-id" class="form-control">
                        <option value="" selected>-- All --</option>

                        <!-- Sound dropdown options here -->

                        <?php while ($sound = $sounds->fetch_assoc()) : ?>
                        <option value="<?php echo $sound["sound_id"] ?>">
                            <?php echo $sound["sound"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox3"
                                value="any" checked>Any
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox1"
                                value="yes">Yes
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input mr-2" type="radio" name="award" id="inlineCheckbox2"
                                value="no">No
                        </label>
                    </div>
                </div>
            </div> <!-- .form-group -->
            <div class="form-group row">
                <label for="date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col">
                            <label class="form-check-label">
                                From:
                                <input type="date" class="form-control mt-2" name="release_date_from">
                            </label>
                        </div> <!-- .col -->
                        <div class="col">
                            <label class="form-check-label">
                                to:
                                <input type="date" class="form-control mt-2" name="release_date_to">
                            </label>
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                </div> <!-- .col -->
            </div> <!-- .form-group -->
            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 mt-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </div>
            </div> <!-- .form-group -->
        </form>
    </div> <!-- .container -->
</body>

</html>