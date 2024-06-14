<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Created</title>
        <style>
            /* Add your custom styles here */
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            .icon {
                text-align: center;
                margin-bottom: 20px;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="icon">
                <img src="{{ $logo }}" alt="Icon" width="50" height="50" />
            </div>

            <h1>Hello!</h1>
            <p>Your account in <b>Becoming Institute</b> has been created. Please check login details below.</p>
            <p><b>Email: </b> {{ $data['email'] }}</p>
            <p><b>Password: </b> {{ $data['password'] }}</p>
            <p>Please make sure to update your password from profile.</p>

            <a href="{{ $url }}" style="color: #fff;" class="button">Visit our site</a>
        </div>
    </body>
</html>