<!DOCTYPE html>
<html>
<head>
    <title>PPC Performance Report</title>
</head>
<body>
    <h2>PPC Performance Report</h2>
    <p>Here’s your latest PPC performance update:</p>

    <table border="1" cellpadding="10">
        <tr>
            <th>Platform</th>
            <th>Clicks</th>
            <th>Conversions</th>
            <th>ROAS</th>
        </tr>
        @foreach ($performance as $platform => $stats)
        <tr>
            <td>{{ $platform }}</td>
            <td>{{ $stats['clicks'] }}</td>
            <td>{{ $stats['conversions'] }}</td>
            <td>{{ $stats['roas'] }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
