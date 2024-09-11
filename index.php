<?php
$weather = '';
$error = '';

if (isset($_POST['submit'])) {
    // This is to check if the city field is empty
    if (empty($_POST['city'])) {
        $error = "Input field empty, please enter a city";
    } else {
        $city = $_POST['city'];
        $apiKey = '01d4e99c0e2ade8331543b4db224b063';
        $api_url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
        
        // Fetch API data with error handling
        $api_data = @file_get_contents($api_url);  // '@' suppresses warnings if the request fails
        if ($api_data === FALSE) {
            $error = "Unable to get weather data. Please enter correct city.";
        } else {
            $weather_data = json_decode($api_data, true);
            
            // This is to check if the response contains valid data
            if ($weather_data && isset($weather_data['main'])) {
                $temperature = $weather_data['main']['temp'];
                $temperature_in_celsius = round($temperature); 
                $temperature_current_weather = $weather_data['weather'][0]['main']; //code to retrieve the temperature in celcius
                $weather_description = $weather_data['weather'][0]['description']; //code to retrieve the weather description
                $weather_icon = $weather_data['weather'][0]['icon'];              //code to get the weather icon image
                $humidity = $weather_data['main']['humidity'];                   //code to get the humdity %
                $wind_speed = $weather_data['wind']['speed'];                   //code to get the wind speed
                
                // Formatting weather data
                $weather ="<b><b/>" ."The current Temperature in $city is $temperature_in_celsius °C with $weather_description<br><br>";
                $weather .= "Humidity is $humidity% <br><br> Wind Speed is $wind_speed m/s";
                $weather .= "<br><img src='http://openweathermap.org/img/wn/$weather_icon@2x.png' />";
            } else {
                $error = "City not found. Please enter a valid city.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>The Weather App</title>

    <style> 
        body {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            background-image: url(https://www.tapsmart.com/wp-content/uploads/2019/05/ventusky-header-1024x512.jpg);
            color: black;
            font-size: Large;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            text-align: center;
            justify-content: center;
            align-items: center;
            width: 440px;
        }
        h1 {
            font-weight: 800px;
            margin-top: 100px;
        }
        input {
            width: 350px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <section>
            <form method="post">
                <h1>The Weather Dashboard App</h1>
                <p><label for="city">Enter your chosen city</label></p>
                <p><input type="text" name="city" id="city" placeholder="City Name"></p>
                <p><p><input name="submit" type="submit" value="Check Weather"></p></p>

                <div class="output">
                    <?php 
                    if ($weather) {
                        echo '<div class="alert alert-info" role="alert">' . $weather . '</div>';
                    }
                    if ($error) {
                        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                    }
                    ?>
                </div>
            </form>      
        </section>
    </div>
</body>
</html>

