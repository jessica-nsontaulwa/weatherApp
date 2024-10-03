# weatherApp
A simple PHP-based weather application that allows users to check the current weather and 16-day forecast for any city. The app integrates the Weatherbit API for fetching weather data and stores recent searches in a MySQL database for easy access to saved locations.

## Table of Contents
1. [Technologies Used](#technologies-used)
2. [Installation](#installation)
3. [Usage](#usage)
4. [API Integration](#api-integration)
5. [Database Schema](#database-schema)
6. [Additional Notes](#additional-notes)

## Technologies Used

- **HTML/CSS**: For the frontend structure and styling of the application.
- **PHP**: Backend language used to handle form submissions, process API requests, and interact with the MySQL database.
- **MySQL**: Database used to store search history (cities and countries).
- **Weatherbit API**: External API used to fetch weather data (current weather and 16-day forecasts).
- **cURL**: PHP extension used for making HTTP requests to the Weatherbit API.

## Installation
1. Clone the repository to your local machine:
    ```bash
    git clone https://github.com/jessica-nsontaulwa/weatherApp.git
    ``` 
2. Ensure you have a local server set up (such as XAMPP, WAMP, or MAMP). Place the cloned project inside the `htdocs` folder (or equivalent folder in your server setup).

3. Create a MySQL database:
    ```sql
    CREATE DATABASE weatherApp;
    ```
4. Import the provided database schema (`weatherApp.sql`) to create the necessary table for storing search history.

5. Update the `dbConn.php` file with your MySQL database credentials:
    ```php
    $conn = new mysqli('localhost', 'username', 'password', 'weather_app');
    ```
6. Ensure that PHP’s `cURL` extension is enabled in your `php.ini` file.

## Usage

1. Open the project in your browser by navigating to `http://localhost/weather-app`.

2. Input a city and the country code (2-letter ISO) to fetch the current weather data and 16-day forecast.

3. You can also view the recent searches by clicking on the "Search History" button, which will display the last five saved cities and countries.

## API Integration

This project uses the **Weatherbit API** for retrieving weather data. Follow these steps to get your API key:

1. Go to [Weatherbit.io](https://www.weatherbit.io/) and sign up for an account.
2. Navigate to the API section and generate an API key.
3. Replace the placeholder in the `weather.php` file with your actual API key:
    ```php
    $api_key = 'enterYourApiKeyHere';
    ```
4. The application makes use of two API endpoints:
    - **Current Weather**: Fetches real-time weather data.
    - **16-Day Forecast**: Provides weather predictions for the upcoming 16 days.
      
## Database Schema

The database consists of one table named `weatherHistory`, which stores the search history:
```sql
CREATE TABLE weatherHistory (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    City VARCHAR(100),
    Country VARCHAR(10),
    dateSearched TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);```











    
