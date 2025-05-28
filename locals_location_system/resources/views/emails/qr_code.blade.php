<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre QR Code</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="20" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-top: 40px;">
                    <tr>
                        <td align="left" style="font-size: 16px;">
                            <p style="margin: 0 0 10px;">Bonjour,</p>
                            <p style="margin: 0 0 20px;">Voici votre QR code de connexion :</p>

                            <p style="font-weight: bold;">Email : <span style="color: #555;">{{ $email }}</span></p>

                            <div style="text-align: center; margin: 20px 0;">
                                <img src="{{ $message->embedData($qrCodeBinary, 'qrcode.png', 'image/png') }}" alt="QR Code" width="200" height="200" style="border: 1px solid #ddd; padding: 8px; border-radius: 4px;" />
                            </div>

                            <p style="font-size: 14px; color: #666;">
                                Ce QR code est personnel et peut être utilisé pour vous connecter rapidement à votre compte.
                                <br>
                                Ne le partagez pas avec d'autres personnes.
                            </p>

                            <p style="margin-top: 30px;">Merci,<br>L'équipe de support</p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 12px; color: #999; margin-top: 20px;">Cet email vous a été envoyé automatiquement. Merci de ne pas y répondre.</p>
            </td>
        </tr>
    </table>
</body>
</html>
