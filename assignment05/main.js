let APIKey = "97b6bef01df804a1801fad036359ec2a";

let popMoviesEndpt = `https://api.themoviedb.org/3/movie/now_playing?api_key=${APIKey}&language=en-US&page=1`;

let popMoviesRequest = new XMLHttpRequest();

popMoviesRequest.open("GET", popMoviesEndpt);
popMoviesRequest.send();

popMoviesRequest.onreadystatechange = function () {

    // Our ready state!
    if (popMoviesRequest.readyState == 4) {
        if (popMoviesRequest.status == 200) {
            /**
             * Table of Contents for requireed items (each within results[i]) –
             * Always shown:
             * Poster img: poster_path
             * Title: title
             * Release date: release_date
             *
             * On hover:
             * Rating: vote_average
             * # Voters: vote_count
             * Synopsis: overview
             */

            displayResults(popMoviesRequest.responseText);
        } else {
            alert("AJAX error!");
            console.log(popMoviesRequest.status);
        }
    }
};

// Create a new API call with the search term given by the user
document.querySelector("#search-form").onsubmit = function (event) {
    event.preventDefault();

    let keyword_id = document.querySelector("#search-input").value;

    let searchTermEndpt = `
https://api.themoviedb.org/3/search/movie?api_key=${APIKey}&language=en-US&query=${keyword_id}&page=1&include_adult=false`;

    let searchTermRequest = new XMLHttpRequest();

    searchTermRequest.open("GET", searchTermEndpt);
    searchTermRequest.send();

    searchTermRequest.onreadystatechange = function () {
        if (searchTermRequest.readyState == 4) {
            if (searchTermRequest.status == 200) {
                displayResults(searchTermRequest.responseText);
            } else {
                alert("AJAX error!");
                console.log(searchTermRequest.status);
            }
        }
    };
};

function displayResults(movieStr) {
    // Clearing row for new elements
    document.querySelector("#movie-row").replaceChildren();

    let formattedStr = JSON.parse(movieStr);

    if (formattedStr.total_results == 0) {
        document.querySelector(
            "#movie-row"
        ).innerHTML += `<img src="images/no_results_found.png" alt="No results found!"></img>`;

        // Updating number of total movies
        document.querySelector(
            "#num-movies"
        ).innerHTML = `<em>Showing <strong>0</strong> out of <strong>0</strong> movies.</em>`;
    } else {
        // Updating number of total movies
        document.querySelector(
            "#num-movies"
        ).innerHTML = `<em>Showing <strong>${Math.min(20, formattedStr.total_results)}</strong> out of <strong>${formattedStr.total_results}</strong> movies.</em>`;

        // Inserting new movies
        formattedStr.results.forEach((result) => {
            // Modifying overview if needed
            if (result.overview.length > 200) {
                let temp = result.overview.substr(0, 200) + "...";
                result.overview = temp;
            }

            let poster_img = `https://image.tmdb.org/t/p/original/${result.poster_path}`;

            // Modifying image if needed
            if (result.poster_path == null) {
                let temp = "images/no_poster_avail.jpeg";

                poster_img = temp;
            }

            // Constructing string
            let htmlStr = `<div class="col col-6 col-md-4 col-lg-3 border">
                    <div class="movie-details">
                        <div class="movie-poster">
                            <img src="${poster_img}" alt="${result.title} poster">
                            <div class="overlay">
                                <div class="rating">
                                    ${result.vote_average}/10 (${result.vote_count} voters)
                                </div>
                                ${result.overview}
                            </div>
                        </div>
                        <div class="movie-text">
                            <h6>${result.title}</h6>
                            <h6>${result.release_date}</h6>
                        </div>
                    </div>
                </div>`;

            // Putting in DOM
            document.querySelector("#movie-row").innerHTML += htmlStr;
        });
    }
}
