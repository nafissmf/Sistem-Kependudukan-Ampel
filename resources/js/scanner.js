import { Html5QrcodeScanner } from 'html5-qrcode';

/**
 * Inisialisasi kamera QR scanner di elemen dengan id tertentu.
 * Saat scan berhasil dan hasilnya berupa URL ke domain sendiri (hasil
 * generate dari QrCodeService), browser langsung diarahkan ke sana —
 * sesuai dokumen "SCAN QR": "Scan berhasil -> Redirect ke halaman detail".
 */
export function initQrScanner(elementId) {
  const scanner = new Html5QrcodeScanner(
    elementId,
    { fps: 10, qrbox: { width: 250, height: 250 }, rememberLastUsedCamera: true },
    false,
  );

  scanner.render(
    (decodedText) => {
      scanner.clear().catch(() => {});
      window.location.href = decodedText;
    },
    () => {
      // Frame tanpa QR terbaca — diabaikan, scanner otomatis lanjut mencoba.
    },
  );

  return scanner;
}

window.initQrScanner = initQrScanner;
