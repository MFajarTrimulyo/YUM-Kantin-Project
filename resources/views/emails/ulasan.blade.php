<!DOCTYPE html>
<html>
<head>
    <title>Ulasan Baru</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo Admin, ada ulasan baru!</h2>
    
    <p><strong>Dari:</strong> {{ $data['email'] }}</p>
    
    <p><strong>Isi Pesan:</strong></p>
    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; border-left: 4px solid #fbbf24;">
        {{ $data['pesan'] }}
    </div>

    <p style="font-size: 12px; color: gray; margin-top: 20px;">Dikirim otomatis dari Website YUM Kantin</p>
</body>
</html>