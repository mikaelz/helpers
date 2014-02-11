<?php

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuoi';
	$consonants = 'bdghjmnpqrstvwx';
	if ($strength) {
		$consonants .= 'BDGHJLMNPQRSTVWX';
	}
	if ($strength) {
		$vowels .= "AEUOI";
	}
	$consonants .= '23456789';

	if ($strength) {
		$consonants .= '#_-';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Password Generator</title>
<style type="text/css">
    body, td, .head td {
        background-color: #fff;
        color: #000;
        font-size: 12px;
        font-family: Arial, sans-serif;
        vertical-align: baseline;
        line-height: 1.5;
        padding: 3px;
    }

    table {
        width: 600px
    }
    
    .pass, .pass input {
        font-size: 14px;
        font-weight: bold;
    }

    .md5 {width: 300px}
    
    .head td {
        border-bottom: solid #000 2px;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 3px 5px 3px;
    }
</style>
</head>
<body>
<center>
<h2>Password Generator</h2>
<table>	
	<tr class="head">
		<td class="pass">Password</td>
		<td>MD5 Hash</td>
	</tr>
<?php
	for ($i = 0; $i < 10; $i++) 
	{
		$passw = generatePassword(14,8);
		?>
		<tr>
			<td class="pass"><input type="text" name="" value="<?php echo $passw;?>" /></td>
			<td><input type="text" class="md5" value="<?php echo md5($passw);?>" /></td>
		</tr>
		<?php
	}
?>
</table>
<br />
<form action="md5.php">
	<input type="submit" value="Refresh">
</form>
<br />
<hr />
<h2>Generate MD5 hash</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="string" value="<?php if (isset($_GET['string'])) echo $_GET['string'] ?>"/>
	<input type="submit" value="Generate MD5" name="gen">

<?php 
if (isset($_GET['string'])) {
    $md5 = md5($_GET['string']);
    echo '<br/><center>'.$md5.'</center>';
    echo '<br/><h3>Check at leakdb</h3><a href="https://leakdb.abusix.com/?q='.$md5.'">https://leakdb.abusix.com/?q='.$md5.'</a>';
}
?>
</form>
</center>
</body>
</html>
