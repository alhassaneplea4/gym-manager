<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport financier {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        .meta { color: #4b5563; margin-bottom: 16px; }
        .total { margin: 12px 0 18px 0; font-size: 14px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Rapport Financier Annuel</h1>
    <div class="meta">GymManager • Année {{ $year }}</div>
    <div class="total">Revenu total: {{ number_format($totalRevenue, 2, ',', ' ') }} FG</div>

    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Revenu</th>
            </tr>
        </thead>
        <tbody>
        @forelse($monthly as $line)
            <tr>
                <td>{{ $line->month_label }}</td>
                <td>{{ number_format($line->revenue, 2, ',', ' ') }} FG</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">Aucune donnée</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>
