<?php

$debug = false;

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

if (!startsWith($_SERVER['REMOTE_ADDR'], '10.237.0.')) {
    http_response_code(403);
    echo "Not authorized\n";
    exit();
}

$buttons = [ "switch", "wii-u", "xbox", "retropie", "chromecast" ];

$selected = false;
foreach ($buttons as $b) {
    if (array_key_exists($b, $_POST)) {
        $selected = $b;
    }
}

if ($selected) {
    $hdmiRoot = '/home/kuno/code/hdmi';
    $cmd = "{$hdmiRoot}/ve/bin/python3 {$hdmiRoot}/send-pronto.py {$hdmiRoot}/inputs/{$selected}";
    $output = [];
    exec($cmd, $output);
}

?>
<!DOCTYPE html>
<html>
   <head>
       <title>Living Room TV</title>
       <meta name="viewport" content="width=550, initial-scale=1" />
       <style>
        body, html { padding: 0; margin: 0; border: 0; background: #222; }

        .buttons { display: grid; width: 550px; padding: 0; margin: 0 auto; border: 0; }
        button { width: 550px; height: 175px; background: #fff; padding: 0; margin: 0 0 20px 0; border: 0; }
        img { padding: 0; margin: 0; }
       </style>
   </head>
   <body>
       <div class="buttons">
           <?php if($debug): ?>
               <pre style="color: #bbb; background: #222"><?php print_r($output); ?></pre>
           <?php endif ?>
           <form method="POST">
               <button type="submit" name="switch" style="background: #f00;"><img src="logo/nintendo-switch.png" /></button>
               <button type="submit" name="wii-u" ><img src="logo/wii-u.png" /></button>
               <button type="submit" name="xbox" ><img src="logo/xbox-one.png" /></button>
               <button type="submit" name="retropie" ><img src="logo/retropie.png" /></button>
               <button type="submit" name="chromecast" ><img src="logo/chromecast.png" /></button>
           </form>
       </div>
   </body>
</html>

