<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title; ?></title>
    </head>
    <body>
        <div style="width: calc(100% - 40px);padding: 20px;text-align: center;">
            <div style="font-size: 24px;font-weight: bold;color: #333;">
                <img src="<?= $base_url; ?>/img/picture-logo.png" alt="Logo" style="width: 100px;height: 100px;border-radius: 50%;margin-right: 10px;" />
            </div>
            <div style="background-color: #fff;max-width: 600px;margin: 20px auto;padding: 20px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);border-radius: 8px;">
                <div style="font-size: 32px;font-weight: bold;color: #333;"><?= $title; ?></div>
                <a href="{{ url('password/reset', $token) }}" style="display: inline-block;padding: 15px 25px;font-size: 16px;color: #fff;background-color: #007bff;text-decoration: none;border-radius: 5px;margin: 20px 0;"><?= $description; ?></a>
                <div style="font-size: 16px;color: #666;line-height: 1.5;margin: 20px 0;"><?= $footer_text; ?></div>
            </div>
            <div style="font-size: 12px;color: #999;margin-top: 20px;">
                Copyright © <?= date("Y"); ?> <a href="<?= $base_url; ?>" style="color: #007bff;text-decoration: none;"><?= $app_name; ?></a>.All Rights Reserved.
            </div>
        </div>
    </body>
</html>