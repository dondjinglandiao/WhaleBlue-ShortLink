<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $mode = getDatabaseMode();
    if ($mode === 'file') {
        showShortLinkForm();
    } elseif ($mode === 'api') {
        showShortLinkForm();
        handleShortLinkForm();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $longUrl = $_POST['long_url'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['captcha'];
    
    session_start();
    if ($_SESSION['captcha'] !== $captcha) {
        showErrorPage('验证码错误');
    }
    
    $random = generateRandomString(5);
    $shortUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $random;

$file1 = __DIR__ .  '/api/data/code.json';
$data1 = file_get_contents($file1);
$json = json_decode($data1, true);
$code = $json['code'];

    $mode = getDatabaseMode();
    if ($mode === 'file') {
        saveToFile($random, $longUrl, $ip);
    } elseif ($mode === 'api') {
        saveToAPI($random, $longUrl, $ip, $code);
    }

    showResultPage($shortUrl);
}

function getDatabaseMode() {
    require __DIR__ .  '/data/databasemode.php';

    return $mode;
}

function showShortLinkForm() {
    echo '<html>';
    echo '<head>';
    echo '<title>WhaleBlue ShortLink</title>';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="stylesheet" href="/css/main-yiyan.css">';
    echo '<script src="/js/main-yiyan.js"></script>';
    echo '<link rel="stylesheet" href="/css/main-styles.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="card">';
    echo '<h1 class="title">WhaleBlue ShortLink</h1>';
    echo '<form method="post" action="">';
    echo '<input type="text" name="long_url" placeholder="http(s)://wlanu.com/…" required>';
    echo '<input type="text" name="captcha" placeholder="验证码" required>';
    echo '<img src="/captcha.php" alt="验证码">';
    echo '<input type="submit" value="生成">';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}

function handleShortLinkForm() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $longUrl = $_POST['long_url'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $random = generateRandomString(5);
        $shortUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $random;

        $mode = getDatabaseMode();
        if ($mode === 'file') {
            saveToFile($random, $longUrl, $ip);
        } elseif ($mode === 'api') {
            saveToAPI($random, $longUrl, $ip, $code);
        }

        showResultPage($shortUrl);
    }
}

function saveToFile($random, $longUrl, $ip) {
    $data = $random . ' ' . $longUrl . ' ' . $ip . PHP_EOL;
    file_put_contents('data/url.txt', $data, FILE_APPEND);
}

function saveToAPI($random, $longUrl, $ip, $code) {
    $apiUrl = "https://" . $_SERVER['HTTP_HOST'] . "/api/?mode=input&random=$random&longurl=$longUrl&ip=$ip&code=$code";

    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ]);

    $response = file_get_contents($apiUrl, false, $context);
}

function showResultPage($shortUrl) {
    echo '<html>';
    echo '<head>';
    echo '<title>WhaleBlue ShortLink</title>';
    echo '<link rel="stylesheet" href="/css/main-styles.css">';
    echo '</head>';
    echo '<body>';
    echo '<h1 class="title">短链接生成成功</h1>';
    echo '<p>' . $shortUrl . '</p>';
    echo '</body>';
    echo '</html>';
}

function showErrorPage($errorMessage) {
    echo '<html>';
    echo '<head>';
    echo '<title>WhaleBlue ShortLink</title>';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="stylesheet" href="/css/main-styles.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="card">';
    echo '<h1 class="title">' . $errorMessage . '</h1>';
    echo '<form method="post" action="">';
    echo '<input type="text" name="long_url" placeholder="http(s)://wlanu.com/…" required>';
    echo '<input type="text" name="captcha" placeholder="验证码" required>';
    echo '<img src="captcha.php" alt="验证码">';
    echo '<input type="submit" value="生成">';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit();
}

function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $max)];
    }
    return $randomString;
}

function curlRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
?>
