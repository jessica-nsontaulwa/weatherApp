<?php 
require_once "dbConn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $api_key = 'enterYourApiKeyHere';  //Add your Api key here
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);


    $sql = "INSERT INTO weatherHistory (City, Country) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $city, $country);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<p style='color:green; text-align:center;'>Record saved successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error: " . mysqli_error($conn) . "</p>";
    }

    mysqli_stmt_close($stmt);
    

    // Current Weather
    $url_current = "https://api.weatherbit.io/v2.0/current?city=" . urlencode($city) . "&country=" . urlencode($country) . "&key=" . $api_key;

    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_current);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    
    if (curl_errno($ch)) {
        echo '<p style="color:red; text-align:center;">Error: ' . curl_error($ch) . '</p>';
    } else {
        $data = json_decode($response, true);
        if (isset($data['data'][0])) {
            $weather = $data['data'][0];

            //Current weather Info
            echo "<div style='background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin: 20px auto; width: 500px;'>";
            echo "<h2 style='color: #75ba75; text-align:center;'>Weather Information for " . htmlspecialchars($weather['city_name']) . ", " . htmlspecialchars($weather['country_code']) . "</h2>";
            echo "<p><strong>Temperature:</strong> " . htmlspecialchars($weather['temp']) . "°C</p>";
            echo "<p><strong>Feels Like:</strong> " . htmlspecialchars($weather['app_temp']) . "°C</p>";
            echo "<p><strong>Weather Description:</strong> " . htmlspecialchars($weather['weather']['description']) . "</p>";
            echo "<p><strong>Wind Speed:</strong> " . htmlspecialchars($weather['wind_spd']) . " m/s</p>";
            echo "<p><strong>Humidity:</strong> " . htmlspecialchars($weather['rh']) . "%</p>";
            echo "<p><strong>Air Quality Index:</strong> " . htmlspecialchars($weather['aqi']) . "</p>";
            echo "<p><strong>Timestamp of Observation:</strong> " . htmlspecialchars($weather['ob_time']) . "</p>";
           
            //form to show 16 days weather
            echo '<form method="post">'; 
            echo '<input type="hidden" name="city" value="'.htmlspecialchars($city).'">';
            echo '<input type="hidden" name="country" value="'.htmlspecialchars($country).'">';
            echo '<button type="submit" name="forecast" style="width: 100%; padding: 10px; background-color: #75ba75; border: none; border-radius: 5px; color: white; cursor: pointer;">16-Day Forecast</button>';
            echo '</form>';
            echo "</div>";
        } else {
            echo "<p style='text-align:center;'>Weather data for the entered city and country could not be found.</p>";
        }
    }

    
    curl_close($ch);

    
    if (isset($_POST['forecast'])) {
        // 16 day Url
        $url_forecast = "https://api.weatherbit.io/v2.0/forecast/daily?city=" . urlencode($city) . "&country=" . urlencode($country) . "&key=" . $api_key;

        
        $ch_forecast = curl_init();
        curl_setopt($ch_forecast, CURLOPT_URL, $url_forecast);
        curl_setopt($ch_forecast, CURLOPT_RETURNTRANSFER, true);
        $response_forecast = curl_exec($ch_forecast);


        if (curl_errno($ch_forecast)) {
            echo '<p style="color:red; text-align:center;">Error: ' . curl_error($ch_forecast) . '</p>';
        } else {
            $forecast_data = json_decode($response_forecast, true);
            if (isset($forecast_data['data']) && count($forecast_data['data']) > 0) {
                echo "<div style='background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin: 20px auto; width: 500px;'>";
                echo "<h2 style='color: #75ba75; text-align:center;'>16-Day Weather Forecast for " . htmlspecialchars($city) . ", " . htmlspecialchars($country) . "</h2>";
                
                // Loop through the forecast data
                foreach ($forecast_data['data'] as $day) {
                    echo "<div style='border: 1px solid #ddd; margin-bottom: 10px; padding: 10px; border-radius: 5px;'>";
                    echo "<p><strong>Date:</strong> " . htmlspecialchars($day['datetime']) . "</p>";
                    echo "<p><strong>Max Temperature:</strong> " . htmlspecialchars($day['max_temp']) . "°C</p>";
                    echo "<p><strong>Min Temperature:</strong> " . htmlspecialchars($day['min_temp']) . "°C</p>";
                    echo "<p><strong>Weather Description:</strong> " . htmlspecialchars($day['weather']['description']) . "</p>";
                    echo "<p><strong>Precipitation:</strong> " . htmlspecialchars($day['precip']) . " mm</p>";
                    echo "<p><strong>UV Index:</strong> " . htmlspecialchars($day['uv']) . "</p>";
                    echo "<p><strong>Wind:</strong> " . htmlspecialchars($day['wind_cdir_full']) . " at " . htmlspecialchars($day['wind_spd']) . " m/s</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p style='text-align:center;'>No forecast data available for this location.</p>";
            }
        }

        curl_close($ch_forecast);
    }
}
?>
