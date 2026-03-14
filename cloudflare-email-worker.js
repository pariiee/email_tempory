/**
 * Cloudflare Email Worker — REVA Mail
 * 
 * Cara deploy:
 * 1. Buka https://dash.cloudflare.com → Workers & Pages → Create → Worker
 * 2. Paste kode ini, klik Deploy
 * 3. Pergi ke Email Routing → Catch-all → Send to Worker → pilih worker ini
 */

export default {
  async email(message, env, ctx) {
    try {
      // Baca raw email
      const rawEmail = await streamToText(message.raw);

      // Ambil subject dari header
      const subject = message.headers.get('subject') || '(Tanpa Subjek)';

      // Ambil nama pengirim dari header "From" (misal: "CapCut <noreply@capcut.com>")
      const fromHeader = message.headers.get('from') || message.from;
      const senderName = extractName(fromHeader);

      // Ambil body teks dari raw email
      const body = extractBody(rawEmail);

      // Cari kode verifikasi (angka 4-8 digit)
      const verificationCode = extractVerificationCode(body);

      // Cari link di dalam body
      const link = extractLink(body);

      // Kirim ke Laravel API
      const response = await fetch('https://revacantik.my.id/api/v1/receive/email', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          to_email: message.to,
          from_email: message.from,
          sender_name: senderName,
          subject: subject,
          body: body,
          verification_code: verificationCode || null,
          link: link || null,
        }),
      });

      const result = await response.json();
      console.log('Email diterima:', result);

    } catch (error) {
      console.error('Error memproses email:', error);
    }
  },
};

// ─── Helper Functions ────────────────────────────────────────────────────────

async function streamToText(stream) {
  const reader = stream.getReader();
  const decoder = new TextDecoder();
  let result = '';
  while (true) {
    const { done, value } = await reader.read();
    if (done) break;
    result += decoder.decode(value, { stream: true });
  }
  return result;
}

function extractName(fromHeader) {
  // "CapCut <noreply@capcut.com>" → "CapCut"
  const match = fromHeader.match(/^"?([^"<]+)"?\s*</);
  if (match) return match[1].trim();
  return fromHeader;
}

function extractBody(rawEmail) {
  // Pisahkan header dan body (dipisah oleh baris kosong ganda)
  const bodyStart = rawEmail.indexOf('\r\n\r\n');
  if (bodyStart === -1) return rawEmail;
  let body = rawEmail.slice(bodyStart + 4);

  // Decode quoted-printable jika ada
  body = body.replace(/=\r\n/g, '').replace(/=([0-9A-F]{2})/gi, (_, hex) =>
    String.fromCharCode(parseInt(hex, 16))
  );

  // Buang tag HTML jika ada
  body = body.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();

  return body.slice(0, 5000); // Batasi 5000 karakter
}

function extractVerificationCode(body) {
  // Cari angka 4-8 digit yang berdiri sendiri (kode OTP/verifikasi)
  const match = body.match(/\b(\d{4,8})\b/);
  return match ? match[1] : null;
}

function extractLink(body) {
  // Cari URL pertama di dalam body
  const match = body.match(/https?:\/\/[^\s"'<>]+/);
  return match ? match[0] : null;
}
