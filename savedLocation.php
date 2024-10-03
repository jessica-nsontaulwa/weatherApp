<?php
require_once "dbConn.php";
class savedLocation {

    public function viewLocation(){
        global $conn;
        $result = mysqli_query($conn, "SELECT * FROM weatherHistory ORDER BY dateSearched DESC LIMIT 5");

        if (mysqli_num_rows($result) > 0) {
            echo "<div style='background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin: 20px auto; width: 80%; max-width: 600px;'>";
            echo "<h2 style='color: #75ba75; text-align:center;'>Saved Cities</h2>";
            
            echo "<table style='width: 100%; border-collapse: collapse; margin: 0 auto;'>";
            echo "<thead>";
            echo "<tr style='background-color: #f5f5f5; text-align: left;'>";
            echo "<th style='padding: 10px; border-bottom: 1px solid #ddd;'>City</th>";
            echo "<th style='padding: 10px; border-bottom: 1px solid #ddd;'>Country</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
        
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td style='padding: 10px; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($row['City']) . "</td>";
                echo "<td style='padding: 10px; border-bottom: 1px solid #ddd;'>" . htmlspecialchars($row['Country']) . "</td>";
                echo "</tr>";
            }
        
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div style='text-align: center; background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin: 20px auto; width: 80%; max-width: 400px;'>";
            echo "<p>No locations found.</p>";
            echo "</div>";
        }
        
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $savedLocation = new savedLocation();
    $savedLocation->viewLocation();
}
?>
