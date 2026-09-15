<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Selesai Ditangani</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 20px;">
    <div style="max-width: 580px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        
        <!-- Header RSUD -->
        <div style="background: linear-gradient(135deg, #062420, #09352e); padding: 25px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 18px; font-weight: 800; letter-spacing: 1px;">RSUD RAA SOEWONDO</h1>
            <p style="margin: 4px 0 0 0; font-size: 12px; color: #5eead4; font-weight: bold; text-transform: uppercase;">IT HELPDESK & TICKETING</p>
        </div>

        <div style="padding: 28px;">
            <div style="display: inline-block; background-color: #ecfdf5; color: #047857; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 6px; text-transform: uppercase; margin-bottom: 12px;">
                Status: Selesai Ditangani
            </div>

            <h2 style="margin: 0 0 10px 0; font-size: 16px; color: #0f172a;">Halo, Pelapor Unit RSUD! 👋</h2>
            <p style="margin: 0 0 20px 0; font-size: 13px; color: #475569; line-height: 1.5;">
                Kabar baik! Pengaduan kendala teknis yang Anda laporkan telah <strong>berhasil diperbaiki dan diselesaikan</strong> oleh Tim IT RSUD Soewondo.
            </p>

            <!-- Tabel Info Tiket -->
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 24px; font-size: 13px;">
                <tr>
                    <td style="padding: 10px 14px; color: #64748b; font-weight: bold; width: 140px; border-bottom: 1px solid #e2e8f0;">Nomor Tiket</td>
                    <td style="padding: 10px 14px; font-family: monospace; font-weight: 800; color: #0f766e; border-bottom: 1px solid #e2e8f0;">{{ $ticket->ticket_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 14px; color: #64748b; font-weight: bold; border-bottom: 1px solid #e2e8f0;">Judul Masalah</td>
                    <td style="padding: 10px 14px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0;">{{ $ticket->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 14px; color: #64748b; font-weight: bold; border-bottom: 1px solid #e2e8f0;">Unit / Ruangan</td>
                    <td style="padding: 10px 14px; font-weight: 600; color: #334155; border-bottom: 1px solid #e2e8f0;">{{ $ticket->unit->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 14px; color: #64748b; font-weight: bold; border-bottom: 1px solid #e2e8f0;">Ditangani Oleh</td>
                    <td style="padding: 10px 14px; font-weight: 700; color: #0f766e; border-bottom: 1px solid #e2e8f0;">{{ $ticket->technician->name ?? 'Tim Teknisi IT' }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 14px; color: #64748b; font-weight: bold;">Waktu Selesai</td>
                    <td style="padding: 10px 14px; font-weight: 600; color: #334155;">{{ $ticket->resolved_at ? $ticket->resolved_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>

            @if($ticket->admin_notes)
                <div style="background-color: #ecfdf5; border: 1px solid #d1fae5; border-left: 4px solid #10b981; padding: 12px; border-radius: 8px; margin-bottom: 24px; font-size: 12px; color: #065f46;">
                    <strong>Catatan Solusi / Tindakan Teknisi:</strong><br>
                    {{ $ticket->admin_notes }}
                </div>
            @endif

            <!-- Tombol Aksi Feedback & Tracking -->
            <div style="text-align: center; margin: 30px 0 10px 0;">
                <a href="{{ route('guest.ticket.track', ['ticket_number' => $ticket->ticket_number]) }}" 
                   style="display: inline-block; background-color: #0f766e; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 12px; font-weight: 800; font-size: 13px; box-shadow: 0 4px 10px rgba(15, 118, 110, 0.3);">
                    ⭐ Beri Penilaian & Rating Kinerja Teknisi &rarr;
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 16px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            Terima kasih telah mempercayakan layanan IT Helpdesk RSUD RAA Soewondo.
        </div>
    </div>
</body>
</html>