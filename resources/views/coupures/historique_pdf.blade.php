<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des coupures</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        h2 { margin-bottom: 5px; }
        p { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Historique des coupures</h2>
    <p>Date d’export : {{ now()->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Début</th>
                <th>Fin</th>
                <th>Durée</th>
                <th>Zone</th>
                <th>Motif</th>
                <th>Priorité</th>
                <th>Gestionnaire</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($coupures as $coupure)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($coupure->date_fin)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $minutes = $coupure->duree_prevue ?? 0;
                            $heures = intdiv($minutes, 60);
                            $reste = $minutes % 60;
                        @endphp
                        {{ $heures > 0 ? $heures . 'h ' : '' }}{{ $reste }}min
                    </td>
                    <td>{{ optional($coupure->zone)->nom ?? 'Zone inconnue' }}</td>
                    <td>{{ $coupure->motif }}</td>
                    <td>{{ ucfirst($coupure->priorite) }}</td>
                    <td>{{ optional($coupure->gestionnaire)->name ?? 'Non attribué' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>