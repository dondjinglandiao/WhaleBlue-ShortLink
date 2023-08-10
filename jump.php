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
        <link rel="stylesheet" href="/css/main-styles.css">
    </head>
    <body>
        <div class="card">
            <h1 class="title">WhaleBlue ShortLink</h1>
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
    <h1>参数错误，请检查 URLID 是否正确</h1>
</body>
</html>
