<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo '<html>';
    echo '<head>';
    echo '<title>WhaleBlue ShortLink</title>';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<style>';
    echo 'body {background-color: #F2F2F2; font-family: Arial, sans-serif;}';
    echo 'h1 {color: #2369F5; text-align: center;}';
    echo 'form {display: flex; flex-direction: column; align-items: center;}';
    echo 'input[type="text"] {width: 400px; padding: 10px; margin-bottom: 10px; border: 1px solid #CCCCCC; border-radius: 5px; outline: none;}';
    echo 'input[type="submit"] {padding: 10px 20px; background-color: #2369F5; color: #FFFFFF; border: none; border-radius: 5px; cursor: pointer;}';
    echo '.card {background-color: white; width: 90%; max-width: 400px; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); text-align: center;}';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="card">';
    echo '<h1>WhaleBlue ShortLink</h1>';
    echo '<form method="post" action="">';
    echo '<input type="text" name="long_url" placeholder="http(s)//…" required>';
    echo '<input type="submit" value="生成">';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $longUrl = $_POST['long_url'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $random = generateRandomString(5);

    $shortUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $random;

    $data = $random . ' ' . $longUrl . ' ' . $ip . PHP_EOL;
    file_put_contents('data/url.txt', $data, FILE_APPEND);

    echo '<html>';
    echo '<head>';
    echo '<title>WhaleBlue ShortLink</title>';
    echo '<style>';
    echo 'body {background-color: #F2F2F2; font-family: Arial, sans-serif;}';
    echo 'h1 {color: #2369F5; text-align: center;}';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<h1>短链接生成成功</h1>';
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
