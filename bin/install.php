<?php

/**
 * GIT DEPLOYMENT SCRIPT
*
* Used for automatically deploying websites via github or bitbucket, more deets here:
*
*		https://gist.github.com/1809044
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

// The commands
$commands = array(
	'echo $PWD',
	'whoami',
	'php -v',
	'bash ./bin/setup.sh',
);

$desc = array(
	//0 => array('pipe', 'r'),
	1 => array('pipe' , 'w'),
	2 => array('pipe', 'w'),
);

// Run the commands for output
$output1 = '';
$output2 = '';
chdir('../');

foreach($commands AS $command){
	// Run it
	$p = proc_open($command, $desc, $pipes);

	$output1 .= stream_get_contents($pipes[1]);
	$output2 .= stream_get_contents($pipes[2]);

	fclose($pipes[1]);
	fclose($pipes[2]);
	proc_close($p);
}

// Make it pretty for manual user access (and why not?)
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  /              &copy; oodavid 2012 |
              |____________________________|

<?php echo $output1; ?>
<?php echo $output2; ?>
</pre>
</body>
</html>