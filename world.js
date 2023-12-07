document.addEventListener("DOMContentLoaded", function() {
    console.log("Page successfully loaded!");
    var lookupButton = document.getElementById("lookup");
    var lookupCities = document.getElementById("lookupCities");
    var countryInput = document.getElementById("country");
    var resultDiv = document.getElementById("result");

    //Event Listener for the first lookup button (Countries)
    lookupButton.addEventListener("click", function(event) {
        event.preventDefault();
        var country = countryInput.value.trim();

        fetch("world.php?country=" + encodeURIComponent(country))
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });

    //Event Listener for the second lookup button (Cities)
    lookupCities.addEventListener("click", function(event) {
        event.preventDefault();
        var country = countryInput.value.trim();

        fetch("world.php?country=" + encodeURIComponent(country) + "&lookup=cities")
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
});