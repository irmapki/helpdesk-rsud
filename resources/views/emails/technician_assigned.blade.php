<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penugasan Tiket Baru</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Halo, {{ $ticket->technician->name ?? 'Teknisi' }}!</h2>
    <p>Anda telah menerima tugas perbaikan baru dari Admin Helpdesk RSUD. Berikut adalah detail tiketnya:</p>
    
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; width: 150px;"><strong>No. Tiket</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->ticket_number }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Judul / Kendala</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->title }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Kategori</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->category->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Unit / Lokasi</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->unit->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Prioritas</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->priority->name ?? '-' }}</td>
        </tr>
    </table>

    <p>Silakan login ke aplikasi Helpdesk untuk melihat detail lengkap dan segera memproses perbaikan tersebut.</p>
    <p>Terima kasih,<br><strong>Sistem Helpdesk RSUD</strong></p>
</body>
</html>