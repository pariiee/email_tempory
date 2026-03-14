# REVA Mail - Email Service

Sebuah layanan email yang dibangun dengan Laravel 12, mirip dengan https://generator.email/

## Fitur Utama

- ✅ **Generate Email Instant** - Buat alamat email dalam hitungan detik
- ✅ **Domain Tunggal** - Menggunakan satu domain (revacantik.my.id) yang bisa diganti
- ✅ **Real-time Email Receiving** - Terima email secara langsung ke inbox
- ✅ **Auto Expiration** - Email otomatis expired setelah waktu yang ditentukan
- ✅ **No Registration** - Tidak perlu registrasi atau informasi pribadi
- ✅ **Privacy Protection** - Data dihapus otomatis setelah expired
- ✅ **API Support** - REST API untuk integrasi dengan sistem lain
- ✅ **Responsive Design** - Tampilan modern dan responsive

## Cara Penggunaan

### 1. Web Interface

1. Buka browser dan kunjungi: `http://127.0.0.1:8000`
2. Klik tombol "Generate Email"
3. Copy alamat email yang dibuat
4. Gunakan alamat email tersebut untuk registrasi atau keperluan lain
5. Kembali ke website untuk melihat email yang masuk
6. Email akan otomatis expired setelah 1 bulan (bisa diperpanjang hingga 1 tahun)

### 2. API Endpoints

#### Generate Email Baru
```bash
POST /api/v1/temp-emails/generate
```

Response:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "email_address": "abc123@revacantik.my.id",
    "domain": "revacantik.my.id",
    "expires_at": "2026-04-14 08:00:00",
    "expires_in_days": 30
  }
}
```

#### Lihat Inbox
```bash
GET /api/v1/temp-emails/{id}/inbox
```

#### Baca Email Spesifik
```bash
GET /api/v1/temp-emails/{emailId}/email/{messageId}
```

#### Perpanjang Waktu Expired
```bash
PUT /api/v1/temp-emails/{id}/extend
Content-Type: application/json

{
  "months": 6
}
```

#### Simulasi Email (Testing)
```bash
POST /api/v1/simulate/email
Content-Type: application/json

{
  "temp_email_id": 1,
  "message_type": "welcome"
}
```

#### Terima Email (Webhook)
```bash
POST /api/v1/receive/email
Content-Type: application/json

{
  "to_email": "test@revacantik.my.id",
  "from_email": "sender@example.com",
  "from_name": "John Doe",
  "subject": "Test Email",
  "body_text": "Hello World",
  "body_html": "<p>Hello World</p>"
}
```

## Setup & Installation

### Requirements
- PHP 8.2+
- Composer
- SQLite (default) atau MySQL/PostgreSQL

### Installation Steps

1. Clone atau download project
2. Install dependencies:
   ```bash
   composer install
   ```

3. Setup environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Konfigurasi database di file `.env`:
   ```
   DB_CONNECTION=sqlite
   ```

5. Run migrations:
   ```bash
   php artisan migrate
   ```

6. Start development server:
   ```bash
   php artisan serve
   ```

7. Buka browser ke `http://127.0.0.1:8000`

## Konfigurasi Domain

Untuk menggunakan domain sendiri, edit file `.env`:

```env
TEMP_EMAIL_DOMAIN=revacantik.my.id
TEMP_EMAIL_DEFAULT_EXPIRY_MONTHS=1
TEMP_EMAIL_MAX_EXPIRY_MONTHS=12
APP_URL=https://revacantik.my.id
```

## Integrasi Email Server

Untuk production, Anda perlu setup email server (Postfix, Exim, dll) untuk forward email ke endpoint webhook:

1. Setup MX record untuk domain
2. Konfigurasi email server untuk forward ke: `https://revacantik.my.id/api/v1/receive/email`
3. Atau gunakan service seperti Mailgun, SendGrid dengan webhook

## Database Schema

### Table: temp_emails
- `id` - Primary key
- `email_address` - Alamat email temporary (unique)
- `domain` - Domain email
- `expires_at` - Waktu expired
- `is_active` - Status aktif/tidak
- `created_at`, `updated_at` - Timestamps

### Table: received_emails  
- `id` - Primary key
- `temp_email_id` - Foreign key ke temp_emails
- `sender_email` - Email pengirim
- `sender_name` - Nama pengirim
- `subject` - Subject email
- `body_text` - Body text email
- `body_html` - Body HTML email
- `received_at` - Waktu terima
- `is_read` - Status sudah dibaca
- `message_id` - ID unik message
- `raw_email` - Raw email data
- `created_at`, `updated_at` - Timestamps

## Security Notes

- Email temporary otomatis dihapus setelah expired
- Tidak ada data pribadi yang disimpan
- Domain bisa dikonfigurasi sesuai kebutuhan
- Rate limiting bisa ditambahkan untuk mencegah spam
- Untuk production, gunakan HTTPS dan validasi input yang ketat

## Testing

### 1. Simulate Email (Internal Testing)
Gunakan fitur "Simulate Email" di web interface atau API endpoint untuk testing tanpa perlu setup email server.

### 2. Simulate Email (Internal Testing)
Gunakan fitur "Simulate Email" di web interface atau API endpoint untuk testing tanpa perlu setup email server:

```bash
# Simulate incoming email via API
POST /api/v1/simulate/email
{
  "temp_email_id": 1,
  "from_email": "test@example.com",
  "sender_name": "Test Sender",
  "subject": "Test Email",
  "body": "This is a test message",
  "verification_code": "123456"
}
```

**💡 Tips Testing:**
- Gunakan simulate email untuk testing cepat
- Untuk production testing, setup mail server atau layanan SMTP
- Pertimbangkan menggunakan mail catcher tools untuk development local

## License

MIT License - Silakan gunakan dan modifikasi sesuai kebutuhan.