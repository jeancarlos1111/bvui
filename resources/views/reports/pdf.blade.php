<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Documentos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #1e6199; margin: 0; padding: 0; }
        .header p { color: #666; margin: 5px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; table-layout: fixed; word-wrap: break-word; }
        table, th, td { border: 1px solid #ddd; }
        th { background-color: #1e6199; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; overflow: hidden; }
        .status { font-weight: bold; }
        .status-Aprobado { color: green; }
        .status-Pendiente { color: orange; }
        .status-Rechazado { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Biblioteca Virtual Universitaria Inteligente</h1>
        <p>Reporte de Producción Académica</p>
        <p>Período: {{ $startDate }} - {{ $endDate }}</p>
        <p>Total de registros: {{ $documents->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Carrera</th>
                <th>Sede</th>
                <th>Fecha de Carga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $doc)
            <tr>
                <td>{{ $doc->id }}</td>
                <td>{{ $doc->title }}</td>
                <td>{{ $doc->category }}</td>
                <td class="status status-{{ $doc->status }}">{{ $doc->status }}</td>
                <td>{{ $doc->career->name ?? 'N/A' }}</td>
                <td>{{ $doc->location->name ?? 'N/A' }}</td>
                <td>{{ $doc->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No hay documentos en este período.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
