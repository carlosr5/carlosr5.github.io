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

// Base SQL call to include everything in the table
$form_sql = "SELECT dvd_titles.title AS 'DVD Title', dvd_titles.release_date AS 'Release Date', genres.genre AS 'Genre', ratings.rating AS 'Rating', dvd_titles.dvd_title_id AS 'dvd_id'
FROM dvd_titles
JOIN genres
    ON dvd_titles.genre_id = genres.genre_id
JOIN ratings
    ON dvd_titles.rating_id = ratings.rating_id
WHERE 1=1";

$count_sql = "SELECT COUNT(*) AS total
FROM dvd_titles
JOIN genres
    ON dvd_titles.genre_id = genres.genre_id
JOIN ratings
    ON dvd_titles.rating_id = ratings.rating_id
WHERE 1=1";

// Appending based on search input
// var_dump($_GET);
if (isset($_GET["title"]) && !empty($_GET["title"])) {
    $form_sql .= " AND dvd_titles.title LIKE '%" . $_GET["title"] . "%'";
    $count_sql .= " AND dvd_titles.title LIKE '%" . $_GET["title"] . "%'";
}
if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
    $form_sql .= " AND dvd_titles.genre_id =" . $_GET["genre"];
    $count_sql .= " AND dvd_titles.genre_id =" . $_GET["genre"];
}
if (isset($_GET["rating"]) && !empty($_GET["rating"])) {
    $form_sql .= " AND dvd_titles.rating_id =" . $_GET["rating"];
    $count_sql .= " AND dvd_titles.rating_id =" . $_GET["rating"];
}
if (isset($_GET["label"]) && !empty($_GET["label"])) {
    $form_sql .= " AND dvd_titles.label_id =" . $_GET["label"];
    $count_sql .= " AND dvd_titles.label_id =" . $_GET["label"];
}
if (isset($_GET["format"]) && !empty($_GET["format"])) {
    $form_sql .= " AND dvd_titles.format_id =" . $_GET["format"];
    $count_sql .= " AND dvd_titles.format_id =" . $_GET["format"];
}
if (isset($_GET["sound"]) && !empty($_GET["sound"])) {
    $form_sql .= " AND dvd_titles.sound_id =" . $_GET["sound"];
    $count_sql .= " AND dvd_titles.sound_id =" . $_GET["sound"];
}
if (isset($_GET["award"]) && !empty($_GET["award"])) {
    if ($_GET["award"] == "yes") {
        $form_sql .= " AND dvd_titles.award IS NOT NULL";
        $count_sql .= " AND dvd_titles.award IS NOT NULL";
    } else if ($_GET["award"] == "no") {
        $form_sql .= " AND dvd_titles.award IS NULL";
        $count_sql .= " AND dvd_titles.award IS NULL";
    }
}
if (isset($_GET["release_date_from"]) && !empty($_GET["release_date_from"])) {
    $date = $_GET['release_date_from'];
    $form_sql .= " AND dvd_titles.release_date > " . "'" . "$date" . "'";
    $count_sql .= " AND dvd_titles.release_date > " . "'" . "$date" . "'";
}

if (isset($_GET["release_date_to"]) && !empty($_GET["release_date_to"])) {
    $date = $_GET['release_date_to'];
    $form_sql .= " AND dvd_titles.release_date < " . "'" . "$date" . "'";
    $count_sql .= " AND dvd_titles.release_date < " . "'" . "$date" . "'";
}


// Finally, append how these should be ordered
$form_sql .= "
ORDER BY dvd_titles.title;";

$form = $mysqli->query($form_sql);
$count = $mysqli->query($count_sql);


// Error handling. Results is false if there are errors
if (!$form || !$count) {
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
    <title>DVD Search Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
        <li class="breadcrumb-item active">Results</li>
    </ol>
    <div class="container-fluid">
        <div class="row">
            <h1 class="col-12 mt-4">DVD Search Results</h1>
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 mt-4">
                <a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row">
            <div class="col-12">
                Showing <?php
                        $num_items = mysqli_fetch_assoc($count);
                        echo $num_items['total'];
                        ?> result(s).

            </div> <!-- .col -->
            <div class="col-12">
                <table class="table table-hover table-responsive mt-4">
                    <thead>
                        <tr>
                            <th>DVD Title</th>
                            <th>Release Date</th>
                            <th>Genre</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($form_item = $form->fetch_assoc()) : ?>
                        <tr>
                            <td>
                                <a href="./details.php?dvd_id=
                                <?php echo $form_item['dvd_id'];
                                ?>
                                ">
                                    <?php echo $form_item["DVD Title"]; ?>
                                </a>
                            </td>
                            <td><?php echo $form_item["Release Date"]; ?></td>
                            <td><?php echo $form_item["Genre"]; ?></td>
                            <td><?php echo $form_item["Rating"]; ?></td>
                        </tr>
                        <?php endwhile; ?>


                    </tbody>
                </table>
            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</body>

</html>