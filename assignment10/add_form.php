<?php
require "config/config.php";

$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();
}

$mysqli->set_charset('utf8');

// We need to display the title, label, sound, genre, rating, and format options. Let's get all of these SQL statements to help us.
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Form | DVD Database</title>
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
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>

    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4 mb-4">Add a DVD</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->

    <div class="container">

        <form action="add_confirmation.php" method="POST">

            <div class="form-group row">
                <label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span
                        class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="title-id" name="title">
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="release-date-id" name="release_date">
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
                <div class="col-sm-9">
                    <select name="label_id" id="label-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <!-- PHP Output Here -->
                        <?php while ($label = $labels->fetch_assoc()) : ?>
                        <option value="<?php echo $label["label_id"] ?>">
                            <?php echo $label["label"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
                <div class="col-sm-9">
                    <select name="sound_id" id="sound-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <!-- PHP Output Here -->
                        <?php while ($sound = $sounds->fetch_assoc()) : ?>
                        <option value="<?php echo $sound["sound_id"] ?>">
                            <?php echo $sound["sound"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
                <div class="col-sm-9">
                    <select name="genre_id" id="genre-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <!-- PHP Output Here -->
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
                    <select name="rating_id" id="rating-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <!-- PHP Output Here -->
                        <?php while ($rating = $ratings->fetch_assoc()) : ?>
                        <option value="<?php echo $rating["rating_id"] ?>">
                            <?php echo $rating["rating"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
                <div class="col-sm-9">
                    <select name="format_id" id="format-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <!-- PHP Output Here -->
                        <?php while ($format = $formats->fetch_assoc()) : ?>
                        <option value="<?php echo $format["format_id"] ?>">
                            <?php echo $format["format"]; ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
                <div class="col-sm-9">
                    <textarea name="award" id="award-id" class="form-control"></textarea>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <div class="ml-auto col-sm-9">
                    <span class="text-danger font-italic">* Required</span>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 mt-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </div>
            </div> <!-- .form-group -->

        </form>

    </div> <!-- .container -->
</body>

</html>