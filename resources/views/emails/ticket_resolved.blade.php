<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Telah Selesai</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Halo, Pelapor / Guest!</h2>
    <p>Kami ingin menginformasikan bahwa laporan kendala Anda telah selesai ditangani dan ditutup oleh tim IT.</p>
    
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; width: 150px;"><strong>No. Tiket</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->ticket_number }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Judul Kendala</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $ticket->title }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Status</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd; color: green; font-weight: bold;">SELESAI / DITUTUP</td>
        </tr>
    </table>

    <p>Jika kendala masih berputar atau ada hal lain yang ingin dikonsultasikan, silakan buat tiket baru melalui sistem helpdesk.</p>
    <p>Terima kasih telah menggunakan layanan Helpdesk RSUD.</p>
    <p>Salam,<br><strong>Tim IT / Helpdesk RSUD</strong></p>
</body>
</html>