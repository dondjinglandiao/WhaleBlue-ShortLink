<?php
$requestedString = trim($_SERVER['PATH_INFO'], '/');

$file = fopen('data/url.txt', 'r');
$found = false;
$url = '';

while (($line = fgets($file)) !== false) {
    $data = explode(' ', $line);
    $urlString = trim($data[0]);
    $url = trim($data[1]);

    if ($requestedString === $urlString) {
        $found = true;
        break;
    }
}

fclose($file);

if ($found) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>WhaleBlue ShortLink ID: <?php echo $urlString; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                background-color: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                margin: 0 20px;
            }
            
            .card {
                background-color: white;
                width: 90%;
                max-width: 400px;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            
            .title {
                font-size: 28px;
                color: #2369F5;
                margin-bottom: 10px;
            }
            
            .content {
                color: #000000;
                margin-bottom: 20px;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .continue-button {
                background-color: #2369F5;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="title">WhaleBlue ShortLink</div>
            <div class="content">
                即将前往第三方网页，该链接由用户提交，请注意您的账号财产安全:<br>
                <span style="color: #97A4B7;"><?php echo $url; ?><hr></span>
            </div>
            <button class="continue-button" onclick="window.location.href='<?php echo $url; ?>'">
                继续访问
            </button>
        </div>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>错误页面</title>
</head>
<body>
    <h1>参数错误，请检查生成的链接是否正确</h1>
</body>
</html>
