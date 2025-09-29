<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Historique des postes créés</h2>

    <table>
        <thead>
            <tr>
                <th>Date de création</th>
                <th>Zone(s)</th>
                <th>Agence(s)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postes as $poste)
                <tr>
                    <td>{{ $poste->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $poste->zones->pluck('nom')->join(', ') ?: '—' }}</td>
                    <td>{{ $poste->zones->pluck('agence.nom')->unique()->join(', ') ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }} — CEET Dashboard
    </div>
</body>
</html>
