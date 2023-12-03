document.addEventListener("DOMContentLoaded", function() {
    console.log("Page successfully loaded!");

    // Listen for clicks on the "Lookup" button
    var lookupButton = document.getElementById('lookup');

    lookupButton.addEventListener("click", function(event) {
        var country = document.getElementById("country").value.trim();
        event.preventDefault();
        // Fetch the data from world.php using AJAX
        fetch(`http://localhost/info2180-lab5/world.php?country=${encodeURIComponent(country)}` )
            .then(response => {
                if (!response.ok) {
                    throw new Error(`An error has occured: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                // Print the data into the div with id "result"
                document.getElementById("result").innerHTML = data;
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    });
});
