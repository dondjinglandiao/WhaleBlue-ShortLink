<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $longUrl = $_POST['long_url'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['captcha'];
    
    session_start();
    if ($_SESSION['captcha'] !== $captcha) {
        echo '<html>';
        echo '<head>';
        echo '<title>WhaleBlue ShortLink</title>';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="/css/main-styles.css">';
        echo '</head>';
        echo '<body>';
        echo '<div class="card">';
        echo '<h1 class="title">验证码错误</h1>';
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
    
    $random = generateRandomString(5);

    $shortUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $random;

    $data = $random . ' ' . $longUrl . ' ' . $ip . PHP_EOL;
    file_put_contents('data/url.txt', $data, FILE_APPEND);

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

function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $max)];
    }
    return $randomString;
}
?>
