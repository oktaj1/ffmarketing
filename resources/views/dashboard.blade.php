<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Light grey background */
            color: #333; /* Dark text color */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center; /* Centering the content */
            align-items: center; /* Vertically centering */
            height: 100vh; /* Full height */
            flex-direction: column; /* Column layout */
        }

        .container {
            max-width: 800px;
            width: 100%; /* Responsive width */
            padding: 20px;
            background-color: #fff; /* White background for content */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s; /* Smooth transitions */
        }

        .container:hover {
            transform: translateY(-5px); /* Lift effect */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Darker shadow on hover */
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            transition: color 0.3s; /* Smooth color transition */
        }

        h1:hover {
            color: #555; /* Darker grey on hover */
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to your Dashboard</h1>
        <p>Here you can manage your settings and view important information.</p>
    </div>
</body>
</html>
