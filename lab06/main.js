$.ajax({
    method: "GET",
    url: "https://api.weatherbit.io/v2.0/current",
    data: {
        key: "9316409de04d4e27834ca4b6504d9f36",
        units: "I",
        city: "Los Angeles"
    }
})
    .done(function (results) {
        // Using JSON object to edit results on page
        displayResults(results);
    })
    .fail();

function displayResults(results) {
    let temp = results.data[0].temp;
    let app_temp = results.data[0].app_temp;
    let desc = results.data[0].weather.description;

    console.log(results);

    $("#header").text(`Weather today in Los Angeles: ${temp}º, ${desc}. Feels like ${app_temp}º`);
}

$("#login-form").on("submit", function (event) {
    event.preventDefault();

    let username = $("#username-input").val();
    let password = $("#password-input").val();

    $.ajax({
        method: "GET",
        url: "https://badlogin.com/login",
        data: {
            username: username,
            password: password
        }
    })
        .done(function (results) {
            let parsedResults = JSON.parse(results);
            let success = parsedResults.success;

            if (success) {
                console.log("Yes");
            }
            else {
                console.log("No");
            }
        })
        .fail();
});