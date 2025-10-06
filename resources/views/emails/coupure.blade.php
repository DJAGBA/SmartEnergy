<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Coupure planifiée</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px;">
        <h2 style="color: #0a58ca;">🔔 Coupure planifiée dans votre zone</h2>

        <p>Bonjour {{ $client->nom ?? 'Client' }},</p>

        <p>
            Nous vous informons qu'une coupure est programmée dans votre zone <strong>{{ optional($coupure->zone)->nom }}</strong>,
            du <strong>{{ \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y à H:i') }}</strong>
            au <strong>{{ \Carbon\Carbon::parse($coupure->date_fin)->format('d/m/Y à H:i') }}</strong>.
            Cette interruption est due à <strong>{{ $coupure->motif }}</strong> et a été classée comme priorité <strong>{{ ucfirst($coupure->priorite) }}</strong>.
        </p>

        <p>
            Nous vous remercions pour votre compréhension et restons à votre disposition pour toute information complémentaire.
        </p>

        <p style="margin-top: 20px;">
            Cordialement,<br>
            <strong>CEET Notification System</strong>
        </p>
    </div>
</body>
</html>