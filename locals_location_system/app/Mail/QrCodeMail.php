<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public string $qrCodeData;
    public string $format;

    public function __construct(string $email, string $qrCodeData, string $format = 'png')
    {
        $this->email = $email;
        $this->qrCodeData = $qrCodeData;
        $this->format = $format;
    }

   public function build()
{
    // Décodez les données base64
    $qrCodeBinary = base64_decode($this->qrCodeData);

    return $this
        ->subject('Votre QR Code de Connexion')
        ->view('emails.qr_code', [
            'email' => $this->email,
            'qrCodeBinary' => $qrCodeBinary, // Données binaires du PNG
        ]);
}


    public function attachments(): array
    {
        return [];
    }
}
