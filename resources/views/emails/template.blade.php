<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .wrapper {
            width: 100%;
            padding: 60px 0;
        }
        .glass-card {
            background-color: rgba(15, 23, 42, 0.95);
            margin: 0 auto;
            width: 90%;
            max-width: 500px;
            border-radius: 60px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }
        .header { padding: 60px 20px 20px 20px; text-align: center; }
        .logo-box {
            display: inline-block;
            padding: 5px 25px;
            border-left: 1px solid rgba(255,255,255,0.1);
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        .logo-text {
            font-size: 28px;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            font-style: italic;
            letter-spacing: -1px;
        }
        .logo-blue { color: #3b82f6; }
        .tagline {
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-top: 15px;
            font-style: italic;
        }
        .content { padding: 40px; text-align: center; }
        .text-body { color: rgba(255,255,255,0.4); font-size: 14px; line-height: 1.8; margin-bottom: 40px; }
        .text-body strong { color: #ffffff; }

        .btn-area { text-align: center; padding-bottom: 60px; }
        .btn-3d {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.5) !important;
            text-decoration: none;
            padding: 22px 55px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 6px 0 #000000;
        }

        .footer {
            padding: 40px 20px;
            text-align: center;
            background-color: rgba(0,0,0,0.2);
        }
        .footer-text-primary {
            color: rgba(255,255,255,0.1);
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-style: italic;
            margin-bottom: 6px;
        }
        .footer-text-secondary {
            color: rgba(59, 130, 246, 0.15);
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="glass-card" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td class="header">
                    <div class="logo-box">
                        <div class="logo-text">WEBGIS <span class="logo-blue">MENTOK</span></div>
                    </div>
                    <div class="tagline">Kecamatan Mentok</div>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <div class="text-body">
                        {!! $content !!}
                    </div>
                </td>
            </tr>
            @if($actionUrl)
            <tr>
                <td class="btn-area">
                    <a href="{{ $actionUrl }}" class="btn-3d">Konfirmasi</a>
                </td>
            </tr>
            @endif
            <tr>
                <td class="footer">
                    <div class="footer-text-primary">&copy; KECAMATAN MENTOK {{ date('Y') }}</div>
                    <div class="footer-text-secondary">DIBUAT OLEH WZ STUDIO</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
