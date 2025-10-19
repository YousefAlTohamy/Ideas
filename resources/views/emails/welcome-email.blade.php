<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ideas!</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .header h1 {
            color: #444;
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }

        .content p {
            margin-bottom: 15px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 15px;
            background-color: #0d6efd;
            /* Bootstrap primary blue */
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Ideas! 🎉</h1>
        </div>
        <div class="content">
            {{-- Use the $user variable passed to the email --}}
            <p>Hi {{ $user->name }},</p>

            <p>Thank you for registering on Ideas! We're excited to have you join our community where you can share,
                discover, and discuss amazing ideas.</p>

            <p>Get started by sharing your first idea or exploring what others are thinking about.</p>

            <p style="text-align: center;">
                <a href="{{ route('dashboard') }}" class="button">Explore Ideas</a>
            </p>

            <p>If you have any questions, feel free to reply to this email.</p>

            <p>Best regards,<br>The Ideas Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Ideas. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
