<?php

//Restart Routine

if($_GET['action']=="Restart")
{
$test=shell_exec("touch /tmp/restart");
echo '<pre>Restarting ... Please refresh after a minute</pre>';
}

//Check config file
$conf = parse_ini_file("/media/drive/conf.ini"); //Conf file fount in the root folder of the external memory device

if(isset($conf['title']))
	{$title=$conf['title'];}
else
	{$title='RaspBi Videos';}

if(isset($conf['videos']))
	{$videodisplay = strtolower($conf['videos']);}

if(isset($conf['video_streaming']))
        {$videostreaming = strtolower($conf['video_streaming']);}

if(isset($conf['labels']))
        {$labels = strtolower($conf['labels']);}

//HTML header
echo '<html>';
echo '<head><title>'.$title.'</title></head>';
echo '<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>';
echo '<script language=javascript>';
echo 'function submitPostLink()';
echo '{';
echo 'document.postlink.submit();';
echo '}';
echo '</script>';

echo '<link href="bootstrap/css/bootstrap.css" rel="stylesheet">';
echo '<link href="my.css" rel="stylesheet">';


if ($videodisplay != 'disabled')
{
//Video streaming
$count = 0;

$videos = glob('/media/drive/videos/*{.mp4}', GLOB_BRACE);
if(!empty($videos))
{
echo '<h1><center>Video</center></h1><br>';
}

echo '<div class="row-fluid">';
echo '<div class="span12">';
foreach ($videos as $video)
{
echo '<div class="span6">';
echo '<video src="/media/drive/videos/'.basename($video).'" controls width = "100%"></video>';
echo '</div>';
$count = $count + 1;
if($count == 2)
{
	echo '</div>';
	echo '<br>';
	echo '<div class="span12">';
	$count = 0;
}
}

echo '</div></div><br>';
}
else
{
echo '<h1><center>No Videos</center></h1>';
}

echo '<br><br>';
//Footer
if(empty($videos))
{
echo '<h1><center>There is nothing to display. Try restarting</center></h1>';
}

echo '<footer>';
echo '<div class="modal-footer">';
echo '<a href="?action=Restart" class="btn btn_primary btn-large">Restart</a>';
echo '</div>';
echo '</footer>';
echo '<script src="jquery-1.9.1.js"></script>';
echo '<script src="bootstrap.js"></script>';
echo '</html>';
?>
