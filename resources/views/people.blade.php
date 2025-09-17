<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People Management</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <h1>People List</h1>
        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <div class="people-list">
            @foreach($people as $person)
                <div class="person">
                    <h2>{{ $person->name }}</h2>
                    <p>{{ $person->bio }}</p>
                    <p>Age: {{ $person->age }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
