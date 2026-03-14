/**
 * Cloudflare Email Worker — REVA Mail
 * 
 * Cara deploy:
 * 1. Buka https://dash.cloudflare.com → Workers & Pages → Create → Worker
 * 2. Paste kode ini, klik Deploy
 * 3. Pergi ke Email Routing → Catch-all → Send to Worker → pilih worker ini
 */

export default {
  // Handler untuk browser (agar tidak error di preview)
  async fetch(request, env, ctx) {
    return new Response('REVA Mail Worker aktif ✅', { status: 200 });
  },

  async email(message, env, ctx) {
    try {
      // Baca raw email
      const rawEmail = await streamToText(message.raw);

      // Ambil subject — handle encoded header =?UTF-8?B?...?= atau =?UTF-8?Q?...?=
      const rawSubject = message.headers.get('subject') || '';
      const subject = decodeEmailHeader(rawSubject) || '(Tanpa Subjek)';

      // Ambil nama pengirim
      const fromHeader = message.headers.get('from') || message.from || '';
      const senderName = extractName(fromHeader) || message.from;

      // Ambil body — support plain text, HTML, dan base64 multipart
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
          from_name: senderName,
          subject: subject,
          body_text: body || '(Isi email tidak dapat dibaca)',
          verification_code: verificationCode || null,
          link: link || null,
        }),
      });

      const result = await response.json();
      console.log('Email diterima:', JSON.stringify(result));

    } catch (error) {
      console.error('Error memproses email:', error.message);
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

// Decode encoded email header =?UTF-8?B?base64?= atau =?UTF-8?Q?quoted?=
function decodeEmailHeader(header) {
  if (!header) return '';
  return header.replace(/=\?([^?]+)\?([BbQq])\?([^?]*)\?=/g, (_, charset, encoding, text) => {
    try {
      if (encoding.toUpperCase() === 'B') {
        // Base64 encoded
        const binary = atob(text);
        const bytes = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
        return new TextDecoder(charset).decode(bytes);
      } else {
        // Quoted-printable
        return text.replace(/_/g, ' ').replace(/=([0-9A-F]{2})/gi, (_, hex) =>
          String.fromCharCode(parseInt(hex, 16))
        );
      }
    } catch {
      return text;
    }
  });
}

function extractName(fromHeader) {
  // "CapCut <noreply@capcut.com>" → "CapCut"
  const match = fromHeader.match(/^"?([^"<]+)"?\s*</);
  if (match) return match[1].trim();
  // Kalau tidak ada nama, ambil bagian sebelum @
  const emailMatch = fromHeader.match(/([^@<\s]+)@/);
  return emailMatch ? emailMatch[1] : fromHeader;
}

function extractBody(rawEmail) {
  // Cari Content-Type untuk tahu format email
  const contentTypeMatch = rawEmail.match(/Content-Type:\s*([^\r\n;]+)/i);
  const contentType = contentTypeMatch ? contentTypeMatch[1].trim().toLowerCase() : '';

  let body = '';

  if (contentType.includes('multipart')) {
    // Ambil boundary
    const boundaryMatch = rawEmail.match(/boundary="?([^"\r\n;]+)"?/i);
    if (boundaryMatch) {
      const boundary = boundaryMatch[1];
      body = extractMultipartBody(rawEmail, boundary);
    }
  } else {
    // Single part
    body = extractSinglePartBody(rawEmail);
  }

  // Buang style & script dulu
  body = body.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '');
  body = body.replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '');

  // Ganti <a href="URL">teks</a> → "teks (URL)" agar link tetap terbaca
  body = body.replace(/<a[^>]+href=["']([^"']+)["'][^>]*>([\s\S]*?)<\/a>/gi, (_, href, text) => {
    const cleanText = text.replace(/<[^>]+>/g, '').trim();
    // Hanya tampilkan URL kalau bukan tracking pixel atau gambar
    if (href.startsWith('http') && cleanText.length > 0) {
      return `${cleanText} → ${href}`;
    }
    return cleanText;
  });

  // Ganti tag lain dengan spasi
  body = body.replace(/<[^>]+>/g, ' ');
  body = body.replace(/&nbsp;/g, ' ').replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&#39;/g, "'").replace(/&quot;/g, '"');
  body = body.replace(/\s+/g, ' ').trim();

  return body.slice(0, 5000);
}

function extractMultipartBody(rawEmail, boundary) {
  const parts = rawEmail.split(new RegExp(`--${escapeRegex(boundary)}`, 'g'));
  let plainText = '';
  let htmlText = '';

  for (const part of parts) {
    if (!part || part.trim() === '--') continue;

    const partContentTypeMatch = part.match(/Content-Type:\s*([^\r\n;]+)/i);
    const partContentType = partContentTypeMatch ? partContentTypeMatch[1].trim().toLowerCase() : '';
    const encodingMatch = part.match(/Content-Transfer-Encoding:\s*([^\r\n]+)/i);
    const encoding = encodingMatch ? encodingMatch[1].trim().toLowerCase() : '';

    // Ambil body bagian ini
    const partBodyStart = part.indexOf('\r\n\r\n');
    if (partBodyStart === -1) continue;
    let partBody = part.slice(partBodyStart + 4).trim();

    // Decode berdasarkan encoding
    if (encoding === 'base64') {
      try {
        const cleaned = partBody.replace(/\s/g, '');
        const binary = atob(cleaned);
        const bytes = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
        partBody = new TextDecoder('utf-8').decode(bytes);
      } catch {
        partBody = '';
      }
    } else if (encoding === 'quoted-printable') {
      partBody = partBody.replace(/=\r\n/g, '').replace(/=([0-9A-F]{2})/gi, (_, hex) =>
        String.fromCharCode(parseInt(hex, 16))
      );
    }

    if (partContentType.includes('text/plain')) {
      plainText = partBody;
    } else if (partContentType.includes('text/html')) {
      htmlText = partBody;
    }
  }

  // Utamakan plain text, fallback ke HTML
  return plainText || htmlText;
}

function extractSinglePartBody(rawEmail) {
  const bodyStart = rawEmail.indexOf('\r\n\r\n');
  if (bodyStart === -1) return '';
  let body = rawEmail.slice(bodyStart + 4);

  const encodingMatch = rawEmail.match(/Content-Transfer-Encoding:\s*([^\r\n]+)/i);
  const encoding = encodingMatch ? encodingMatch[1].trim().toLowerCase() : '';

  if (encoding === 'base64') {
    try {
      const cleaned = body.replace(/\s/g, '');
      const binary = atob(cleaned);
      const bytes = new Uint8Array(binary.length);
      for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
      return new TextDecoder('utf-8').decode(bytes);
    } catch {
      return '';
    }
  } else if (encoding === 'quoted-printable') {
    return body.replace(/=\r\n/g, '').replace(/=([0-9A-F]{2})/gi, (_, hex) =>
      String.fromCharCode(parseInt(hex, 16))
    );
  }

  return body;
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

function escapeRegex(str) {
  return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}
