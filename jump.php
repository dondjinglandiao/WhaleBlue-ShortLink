<?php
$requestedString = trim($_SERVER['PATH_INFO'], '/');
$domain = $_SERVER['HTTP_HOST'];

require __DIR__ . '/data/databasemode.php';
$ModeIF = $mode == "file";

$found = false;

if ($ModeIF) {
    $file = fopen('data/url.txt', 'r');
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
} else {
    $file = __DIR__ .  '/api/data/code.json';
    $data = file_get_contents($file);
    $json = json_decode($data, true);
    $code = $json['code'];
    $apiurl = "https://$domain/api/?mode=output&random=$requestedString&longurl=&ip=&code=$code";
    $opts = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false
        )
    );
    $context = stream_context_create($opts);
    $url = file_get_contents($apiurl, false, $context);

    if ($url !== 'No data found') {
        $found = true;
    }
}

if ($found) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>WhaleBlue ShortLink ID: <?php echo $requestedString; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/main-yiyan.css">
        <script src="/js/main-yiyan.js"></script>
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
