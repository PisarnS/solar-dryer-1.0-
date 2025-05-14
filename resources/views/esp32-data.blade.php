<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">ESP32 Data</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Temperature (°C)</th>
                    <th>Humidity (%)</th>
                    <th>weight (°C)</th>
                    <th>LightIntensity (%)</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @if($data->isEmpty())
                    <tr> 
                        <td colspan="4" class="text-center">No Data Available</td>
                    </tr>
                @else
                    @foreach ($data as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td>{{ $entry->temperature }}</td>
                            <td>{{ $entry->humidity }}</td>
                            <td>{{ $entry->weight }}</td>
                            <td>{{ $entry->LightIntensity }}</td>
                            <td>{{ $entry->created_at }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
