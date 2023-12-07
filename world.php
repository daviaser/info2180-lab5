<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
function operation($results){
    //Output the results in a HTML Table based on the search type
    if (!empty($results)){
        echo '<table style="border:1px solid grey; border-collapse:collapse; background-color:rgb(250, 249, 246);">';
        echo '<thead style="background-color:rgb(120, 188, 228);">';
        echo '<tr>';
        if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
            echo '<th style="border:1px solid grey;">City Name</th>';
            echo '<th style="border:1px solid grey; padding:20px;">District</th>';
            echo '<th style="padding:10px; border:1px solid grey;">Population</th>';
        }else {
            echo '<th style="border:1px solid grey; padding:10px;">Country Name</th>';
            echo '<th style="border:1px solid grey;">Continent</th>';
            echo '<th style="padding:20px; border:1px solid grey;">Independence Year</th>';
            echo '<th style="padding:10px;">Head of State</th>';
        }
            echo '</tr>';
            echo '</thead>';
            echo '<tbody style="border:1px solid grey;padding:10px;">';
            foreach ($results as $row) {
                echo '<tr style="border:1px solid grey; padding:10px;">';
                if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
                    echo '<td style="border:1px solid grey; padding:10px;">' . htmlspecialchars($row['city_name']) . '</td>';
                    echo '<td style="border:1px solid grey; text-align:center;">' . htmlspecialchars($row['district']) . '</td>';
                    echo '<td style="text-align:center;">' . htmlspecialchars($row['population']) . '</td>';
                } else {
                    echo '<td style="border:1px solid grey; padding:10px;">' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td style="border:1px solid grey; padding:10px;">' . htmlspecialchars($row['continent']) . '</td>';
                    echo '<td style="border:1px solid grey; text-align:center;">' . htmlspecialchars($row['independence_year']) . '</td>';
                    echo '<td style="border:1px solid grey; text-align:center; padding:10px;">' . htmlspecialchars($row['head_of_state']) . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }}

//Checking if the request is a 'GET' request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sanitizes the user's input
    $userInput = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING);
    $country = '%' . $userInput . '%';

    if ($userInput !== null) {
        if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
            $statement = $conn->prepare('SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name
                FROM cities
                JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE :country');
            $statement->bindParam(':country', $country, PDO::PARAM_STR);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            operation($results);


        } else {
            $statement = $conn->prepare('SELECT * FROM countries WHERE name LIKE :country');
            $statement->bindParam(':country', $country, PDO::PARAM_STR);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            operation($results);
        }

    } 
    
    if($userInput !== null && empty($results)){
        echo "<strong>No results were yielded for that particular search. Please check the spelling or try entering a different country.</strong>";
    }
    
}
?> 
