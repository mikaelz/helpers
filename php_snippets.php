<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>PHP snippets</title>
	<style media="screen">
		body {
            margin: 0 auto;
            width: 1200px;
		}
		.code {
			background: #f1f1f1;
			border: 1px solid #ccc;
			font-size: 110%;
			padding: 15px 5px 0 5px;
			width: 95%;
		}
	</style>
</head>
<body>
	<h1>PHP snippets</h1>
	<h2>Server variables</h2>
    <pre class="code">
    <?php print_r($_SERVER); ?>
    </pre>
    <br/>
	<h2>File upload</h2>
	<p>The <em>form</em> needs to be set to <em>enctype="multipart/form-data"</em></p>
	<pre class="code">
if ($_FILES['image']['name'] != '') {
    $err = 0;
    $fn = strtolower(preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['image']['name']));
    $ext = pathinfo($fn, PATHINFO_EXTENSION);

    if (!preg_match('/(jpg|gif|png)/i', $ext)) {
        echo 'Filetype not supported.';
        $err++;
    }

    if ($_FILES['image']['size'] &gt; 1000000) {
        echo 'File size too high, 1MB is allowed.';
        $err++;
    }

    if (1 > $err) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$fn);
    }
}
	</pre>
	<br>
    <h2>PHPmailer</h2>
    <p>More @ <a href="https://github.com/Synchro/PHPMailer#a-simple-example">https://github.com/Synchro/PHPMailer#a-simple-example</a></p>
    <p>Source @ <a href="https://github.com/Synchro/PHPMailer">https://github.com/Synchro/PHPMailer</a></p>
    <pre class="code">
require_once PATH . '/include/phpmailer/class.phpmailer.php';

$html_mail = 'MAIL_TEXT';
$text_mail = strip_tags(str_ireplace(array('&lt;br&gt;;','&lt;br/&gt;','&lt;br /&gt;','&#160;'), "\r\n", $html_mail));

$mailer              = new PHPMailer();
$mailer-&gt;IsSMTP();
$mailer-&gt;Host        = SMTP_HOST;
$mailer-&gt;SMTPDebug   = 0;
$mailer-&gt;SMTPAuth    = true;
$mailer-&gt;Port        = 25;
$mailer-&gt;Username    = SMTP_USER;
$mailer-&gt;Password    = SMTP_PASS;
$mailer-&gt;From        = SERVER_EMAIL;
$mailer-&gt;FromName    = DOMAIN;
$mailer-&gt;Subject     = $subject;
$mailer-&gt;CharSet     = 'utf-8';
$mailer-&gt;IsHTML(true);
$mailer-&gt;AddAddress(TO_EMAIL, DISPLAY_NAME);
$mailer-&gt;AddReplyTo(SERVER_EMAIL, DOMAIN);
$mailer-&gt;AddAttachment('FILE_PATH', 'FILE_NAME');
$mailer-&gt;Body        = $html_mail;
$mailer-&gt;AltBody     = $text_mail;

if ($mail-&gt;Send()) {
    echo 'Mail sent';
}
else {
    echo 'Mail error';
}
    </pre>
    <br>
	<h2>Validate email</h2>
    <pre class="code">
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo '&lt;br&gt;&lt;p class="notice"&gt;Neplatná emailová adresa.&lt;/p&gt;';
    return false;
}
    </pre>
    <br>
	<h2>Secure POST or GET</h2>
	<pre class="code">
$secured_post = array_map('htmlspecialchars', array_map('strip_tags', $_POST));
	</pre>
	<br>
	<h2>Validate e-mail</h2>
	<pre class="code">
function checkEmail($email) {
	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
		list($username,$domain)=split('@',$email);

		if(!checkdnsrr($domain,'MX'))
			return false;

		return true;
	}

	return false;
}
	</pre>
	<br>
    <h2>AJAX request handling</h2>
    <p><a href="https://www.owasp.org/index.php/OWASP_AJAX_Security_Guidelines#Services_can_be_called_by_users_directly" target="_blank">https://www.owasp.org/index.php/OWASP_AJAX_Security_Guidelines#Services_can_be_called_by_users_directly</a></p>
	<pre class="code">
if (strtolower(@$_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
    strpos(@$_SERVER['HTTP_REFERER'], DOMAIN) !== false &&
    @$_COOKIE['s'] == session_id()) {

    $data = array();
    echo json_encode($data);
}
    </pre><br>
	<h2>Multiple MySQL INSERT</h2>
	<pre class="code">
$sql = array();
for ($i = 0; $i &lt; 300000; $i++)
{
	$sql[] = '("'.'Webdesign'.'", "Popis sluzby")';
}
mysql_real_escape_string($sql);

mysql_query("INSERT INTO ".TABLE_PREFIX."mod_eshop_items (`title`, `desc`) VALUES".implode(',', $sql));

	</pre>
	<br>
	<h2>MySQL INSERT array</h2>
	<pre class="code">
$arr = array(
    'column1' =&gt; 'value1',
    'column2' =&gt; 'value2',
    'column3' =&gt; 'value3',
);
$q = sprintf("INSERT INTO test_table (`%s`) VALUES('%s')", implode("`,`", array_keys($arr)), implode("','", array_values($arr)));

mysql_query($q);

	</pre>
	<br>
	<h2>cURL get content</h2>
	<pre class="code">
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.etrend.sk/rss/ekonomika.xml');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

if ($result === false)
	echo 'Nepodarilo sa stiahnúť správy.';
	</pre>
	<br>
	<h2>cURL file download</h2>
	<pre class="code">
$url = 'http://www.neville.sk/index.php';
$filename = substr($url, strrpos($url, '/'), strlen($url));
$output = fopen(dirname(__FILE__).$filename, 'wb');

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FILE, $output);

if(curl_exec($ch) === false)
	echo 'cURL error: ' . curl_error($ch).PHP_EOL;
else
	echo 'XML uložený'.PHP_EOL;

curl_close($ch);

fclose($output);
	</pre>
	<br>
	<h2>Get filename from URL</h2>
	<pre class="code">
$filename = basename(parse_url('http://www.neville.sk/index.php', PHP_URL_PATH));
	</pre>
	<br>
	<h2>Get domain from URL</h2>
	<pre class="code">
$domain = str_replace('www.', '', parse_url('http://www.neville.sk/index.php', PHP_URL_HOST));
	</pre>
	<h2>Minify CSS</h2>
	<pre class="code">
function minify_css($str)
{
	$str = str_replace(array("\r","\n"), '', $str);
	$str = preg_replace('`([^*/])\/\*([^*]|[*](?!/)){5,}\*\/([^*/])`Us', '$1$3', $str);
	$str = preg_replace('`\s*({|}|,|:|;)\s*`', '$1', $str);
	$str = str_replace(';}', '}', $str);
	$str = preg_replace('`(?=|})[^{}]+{}`', '', $str);
	$str = preg_replace('`[\s]+`', ' ', $str);

	return $str;
}
	</pre>
	<br>
	<h2>Truncate string</h2>
	<pre class="code">
function truncate($string, $max_length = 30, $replacement = '', $trunc_at_space = false) {
	$max_length -= strlen($replacement);
	$string_length = strlen($string);

    if ($string_length &lt;= $max_length) {
        return $string;
    }

	if ($trunc_at_space &amp;&amp; ($space_position = strrpos($string, ' ', $max_length-$string_length))) {
        $max_length = $space_position;
    }

	return substr_replace($string, $replacement, $max_length);
}

	</pre>
	<br>
	<h2>String to URL link</h2>
	<pre class="code">
function to_permalink($str) {
	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8');
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&amp;([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	$str = strtolower( trim($str, '-') );
	return $str;
}

	</pre>
	<br>
	<h2>Regex file extension</h2>
	<pre class="code">
preg_match('/\.(jpg|gif|png)/i', $text);
	</pre>
	<br>
	<h2>Modify URL param</h2>
	<p>Current URL http://www.example.com/page.php?p=5&amp;show=list&amp;style=2 after <br>
	$url = modify_url(array('p' =&gt; 4, 'show' =&gt; 'column')); <br>
	URL will become http://www.example.com/page.php?p=4&amp;show=column&amp;style=2</p>
	<pre class="code">
function modify_url($mod){
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $query = explode("&amp;", $_SERVER['QUERY_STRING']);
    if (!$_SERVER['QUERY_STRING']) {$queryStart = "?";} else {$queryStart = "&amp;";}
    // modify/delete data
    foreach($query as $q) {
        list($key, $value) = explode("=", $q);
        if(array_key_exists($key, $mod)) {
            if($mod[$key]) {
                $url = preg_replace('/'.$key.'='.$value.'/', $key.'='.$mod[$key], $url);
            }
            else {
                $url = preg_replace('/&amp;?'.$key.'='.$value.'/', '', $url);
            }
        }
    }
    // add new data
    foreach($mod as $key =&gt; $value) {
        if($value &amp;&amp; !preg_match('/'.$key.'=/', $url)) {
            $url .= $queryStart.$key.'='.$value;
        }
    }
    return $url;
}
	</pre>
	<br>
	<h2>Read directory</h2>
	<pre class="code">
$dir = dir($path);
$counter = 1;
$files_arr = array();

while (false !== $file = $dir-&gt;read()) {
	// Skip index file and pointers
	if(eregi(".php", $file) || substr($file, 0, 1) == ".")
		continue;

	if(file_exists($file))
		$files_arr[] = $file;
}
	</pre>
	<br>
	<h2>Fetch file content into variable</h2>
	<pre class="code">
ob_start();
require 'file.php';
$file_cnt = ob_get_contents();
ob_end_clean();
	</pre>
	<br>
	<h2>Non-ascii to ascii</h2>
	<pre class="code">
function ascii_convert($string) {
    $table = array(
        'Š'=&gt;'S', 'š'=&gt;'s', 'Ž'=&gt;'Z', 'ž'=&gt;'z', 'Č'=&gt;'C', 'č'=&gt;'c', 'Ć'=&gt;'C', 'ć'=&gt;'c',
        'À'=&gt;'A', 'Á'=&gt;'A', 'Â'=&gt;'A', 'Ã'=&gt;'A', 'Ä'=&gt;'A', 'Å'=&gt;'A', 'Æ'=&gt;'A', 'Ç'=&gt;'C', 'È'=&gt;'E', 'É'=&gt;'E',
        'Ê'=&gt;'E', 'Ë'=&gt;'E', 'Ì'=&gt;'I', 'Í'=&gt;'I', 'Î'=&gt;'I', 'Ï'=&gt;'I', 'Ñ'=&gt;'N', 'Ò'=&gt;'O', 'Ó'=&gt;'O', 'Ô'=&gt;'O',
        'Õ'=&gt;'O', 'Ö'=&gt;'O', 'Ø'=&gt;'O', 'Ù'=&gt;'U', 'Ú'=&gt;'U', 'Û'=&gt;'U', 'Ü'=&gt;'U', 'Ý'=&gt;'Y', 'Þ'=&gt;'B', 'ß'=&gt;'Ss',
        'à'=&gt;'a', 'á'=&gt;'a', 'â'=&gt;'a', 'ã'=&gt;'a', 'ä'=&gt;'a', 'å'=&gt;'a', 'æ'=&gt;'a', 'ç'=&gt;'c', 'è'=&gt;'e', 'é'=&gt;'e',
        'ê'=&gt;'e', 'ë'=&gt;'e', 'ì'=&gt;'i', 'í'=&gt;'i', 'î'=&gt;'i', 'ï'=&gt;'i', 'ð'=&gt;'o', 'ñ'=&gt;'n', 'ò'=&gt;'o', 'ó'=&gt;'o',
        'Ő'=&gt;'O', 'ő'=&gt;'o', 'ô'=&gt;'o', 'õ'=&gt;'o', 'ö'=&gt;'o', 'ø'=&gt;'o', 'ù'=&gt;'u', 'ú'=&gt;'u', 'û'=&gt;'u', 'Ű'=&gt;'U',
        'ű'=&gt;'u', 'ü'=&gt;'u', 'ý'=&gt;'y', 'ý'=&gt;'y', 'þ'=&gt;'b', 'ÿ'=&gt;'y', 'Ŕ'=&gt;'R', 'ŕ'=&gt;'r',
        'Đ'=&gt;'Dj', 'đ'=&gt;'dj',
    );
    
    return strtr($string, $table);
}
	</pre>
    <br>
    <h2>Get file extension</h2>
    <pre class="code">
    pathinfo(FILE, PATHINFO_EXTENSION);
    </pre>
    <br>
    <h2>Parse CSV into array</h2>
    <pre>
    $data = array();
    $file = file('items.csv');
    foreach ($file as $lineNumber =&gt; $line) {
        if($lineNumber == 0) {
            $keys  = explode(',', $line);
            foreach($keys as $k =&gt; $v) {
                $keys[$k] = str_replace('"', '', trim($v));
            }
        }
        else {
            $values = explode(',', $line);
            $data[$lineNumber-1] = str_replace('"', '', array_combine($keys, $values));
        }
    }
    </pre>
    <br/>
    <h2>Geocode address</h2>
    <pre class="code">
    $location = 'Slovakia';
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false');
    $output = json_decode($geocode);

    $lat  = $output-&gt;results[0]-&gt;geometry-&gt;location-&gt;lat;
    $long = $output-&gt;results[0]-&gt;geometry-&gt;location-&gt;lng;
    </pre>
    <br/>
    <h2>Create phpmailer.log</h2>
    <pre class="code">
        //*************** email log ******************
        $fp = fopen('phpmailer.log', 'a+');
        fwrite($fp, date('d.m.Y H:i:s').' - '.var_export($mail, true));
        fwrite($fp, "\n------- next log entry ------\n");
        fclose($fp);
        //*************** email log ******************
    </pre>
</body>
</html>
