<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Verification</title>
    </head>

    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            <tr>
                <td style="padding: 20px 0; text-align: center; background-color: #1e90ff;">
                    <img src="https://via.placeholder.com/150x50?text=Your+Logo" alt="Your Logo"
                        style="max-width: 150px; height: auto;">
                </td>
            </tr>
            <tr>
                <td style="padding: 40px 30px;">
                    <h1 style="color: #1e90ff; font-size: 24px; margin-bottom: 20px;">Verify Your Email Address</h1>
                    <p style="color: #333333; font-size: 16px; line-height: 1.5;">Thank you for signing up! Please click
                        the button below to verify your email address and activate your account.</p>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="margin-top: 30px; margin-bottom: 30px;">
                        <tr>
                            <td align="center">
                                <a href="{{ $url }}"
                                    style="display: inline-block; padding: 12px 24px; background-color: #1e90ff; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">Verify
                                    Email</a>
                            </td>
                        </tr>
                    </table>
                    <p style="color: #666666; font-size: 14px; line-height: 1.5;">If you didn't create an account, you
                        can safely ignore this email.</p>
                </td>
            </tr>
            <tr>
                <td
                    style="padding: 20px 30px; background-color: #f0f8ff; text-align: center; color: #666666; font-size: 14px;">
                    <p>&copy; 2023 Your Company. All rights reserved.</p>
                </td>
            </tr>
        </table>
    </body>

</html>
