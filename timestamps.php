<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UNIX timestamps</title>
<style>
body {
	font-family: serif;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}
td {
	padding: .33em 1em;
	border: 1px solid #222;
    text-align: center;
}
td:first-child {
    text-align: left;
}
.wider {
	width: 240px;
}
</style>
</head>
<body>
<center>
	<h1><a href="<?php echo $_SERVER['PHP_SELF'] ?>">UNIX timestamps</a> (now: <?php echo time(); ?>)</h1>
	<table>
        <tr>
            <th>Interval</th>
            <th>Past</th>
            <th>Future</th>
        </tr>
		<tr>
			<td>1 day</td>
			<td><?php echo $ts = strtotime('-1 day'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+1 day'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>1 week</td>
			<td><?php echo $ts = strtotime('-1 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+1 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>2 weeks</td>
			<td><?php echo $ts = strtotime('-2 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+2 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>3 weeks</td>
			<td><?php echo $ts = strtotime('-3 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+3 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>4 weeks</td>
			<td><?php echo $ts = strtotime('-4 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+4 week'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>1 month</td>
			<td><?php echo $ts = strtotime('-1 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+1 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>2 months</td>
			<td><?php echo $ts = strtotime('-2 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+2 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>3 months</td>
			<td><?php echo $ts = strtotime('-3 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+3 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>6 months</td>
			<td><?php echo $ts = strtotime('-6 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+6 month'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>1 year</td>
			<td><?php echo $ts = strtotime('-1 year'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
			<td><?php echo $ts = strtotime('+1 year'); echo '<br><small>' . date('d.m.Y', $ts) . '</small>'; ?></td>
		</tr>
		<tr>
			<td>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
					<input type="text" name="timestamp" placeholder="<?php echo time() ?>" value="<?php if(isset($_GET['timestamp'])) echo $_GET['timestamp'] ?>" />
					<input type="submit" name="parse" value="Show" id="parse" />
				</form>
			</td>
			<td colspan="2" class="wider">
			<?php 
			if (isset($_GET['parse'])) {
				echo date('d.m.Y H:i:s', $_GET['timestamp']);
			}
			?>
			</td>
		</tr>
		<tr>
			<td>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
					<input type="text" name="date" placeholder="<?php echo date('d.m.Y') ?>" value="<?php if(isset($_GET['date'])) echo $_GET['date'] ?>" />
					<input type="submit" name="parse2" value="Show" />
				</form>
			</td>
			<td colspan="2" class="wider">
			<?php 
			if (isset($_GET['parse2'])) {
				echo strtotime($_GET['date']);
			}
			?>
			</td>
		</tr>
	</table>
</center>
</body>
</html>
