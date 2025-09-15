<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People Management</title>

    <!-- Link to CSS (Compiled by Laravel Mix) -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"> <!-- Only link it once -->
</head>

<body>
    <!-- React will render content here -->
    <div id="app"></div>

    <!-- Laravel backend functionality -->
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <!-- Link to compiled React JS -->
    <script src="{{ mix('js/app.js') }}"></script> <!-- This links the compiled React JS -->
</body>

</html>
