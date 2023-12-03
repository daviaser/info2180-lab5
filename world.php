<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if it's a GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Initializing the GET request of 'country'
    $country = $_GET['country'];
    
    if (!empty($_GET['country'])) {
        $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");

        // Fetch the result
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // If 'country' parameter is not present, fetch all countries
        $stmt = $conn->query("SELECT * FROM countries");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<ul>';
            foreach ($results as $row) {
                echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
            }
            echo '</ul>';
    }

    // Output the data
    if (empty($results)) {
        echo "No data was found for the country: " . (isset($country) ? $country : 'All countries');
    } else{
        echo '<ul>';
        foreach ($results as $row) {
            echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
        }
        echo '</ul>';
    }
}
?>