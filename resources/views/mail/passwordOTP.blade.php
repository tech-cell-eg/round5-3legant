<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: Arial, sans-serif; background-color:#f5f5f5; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f5f5; padding:20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td
                            style="background-color:#007bff; padding:16px; text-align:center; color:#ffffff; font-size:20px; font-weight:bold;">
                            Password Reset Request
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px; color:#333333; font-size:16px; line-height:1.5;">
                            <p>Hello,</p>
                            <p>We received a request to reset your password. Use the OTP below to proceed:</p>
                            <p style="text-align:center; margin:30px 0;">
                                <span
                                    style="font-size:28px; font-weight:bold; letter-spacing:4px; color:#007bff;">{{ $code }}</span>
                            </p>
                            <p>This code will expire in <strong>10 minutes</strong>. If you did not request a password
                                reset, you can safely ignore this email.</p>
                            <p style="margin-top:30px;">Thanks ^^</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
