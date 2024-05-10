<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;

        }
        ul{
            list-style: none;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
        <!-- resources/views/results.blade.php -->
        <h1>Search Results for: {{ $firstName }} {{ $lastName }}</h1>
        <hr>
        <ul>
            @foreach ($result as $person)
                <li>
                    <p><b>Name:</b> {{ $person['name'] }}</p>
                </li>
                <li>
                    <p><b>Age:</b> {{ $person['age'] }}</p>
                </li>
                <li><b>Location:</b> {{ $person['location'] }}</li>
                <li><b>Relatives:</b> {{ implode(', ', $person['relatives']) }}</li>
                <hr>
            @endforeach
        </ul>
</body>

</html>
