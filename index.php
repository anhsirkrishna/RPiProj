<?php

//Restart Routine

if($_GET['action']=="Restart")
{
$test=shell_exec("touch /tmp/restart");
echo '<pre>Restarting ... Please refresh after a minute</pre>';
}

//Record vid routine
if($_GET['action']=="Record")
{
 $command = escapeshellcmd("./recvid.py");
 $time = exec($command);
 $test = exec("./savevid.sh");
 //echo '<pre>'.$time.'</pre>';
 header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/");
}

//capture image routine
if($_GET['action']=="Capture")
{
 $command = escapeshellcmd("./capimg.py");
 $test1 = exec($command);
 $test2 = exec("./saveimg.sh");
 echo '<pre>'.$test1.'</pre>';
 //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/");
}

//Del img and vid routine
$del_vid = $_GET['delete'];
$del_img = $_GET['deleteimg'];
if(isset($del_vid))
{
 $command = escapeshellcmd("./delvid.sh $del_vid");
 //echo '<pre>'.$command.'</pre>';
 $test = exec($command);
 header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/");
}

if(isset($del_img))
{
 $command = escapeshellcmd("./delimg.sh $del_img");
 $test = exec($command);
 //echo '<pre>'.$test.'</pre>'; 
 header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/");
}

$size = exec("./check_space.sh");


//Check config file
$conf = parse_ini_file("/media/drive/conf.ini"); //Conf file fount in the root folder of the external memory device

if(isset($conf['title']))
	{$title=$conf['title'];}
else
	{$title='RaspBi Videos';}

if(isset($conf['videos']))
	{$videodisplay = strtolower($conf['videos']);}

if(isset($conf['images']))
        {$imagedisplay = strtolower($conf['images']);}

if(isset($conf['video_streaming']))
        {$videostreaming = strtolower($conf['video_streaming']);}

if(isset($conf['labels']))
        {$labels = strtolower($conf['labels']);}


//HTML header
echo '<html>';
echo '<head><title>'.$title.'</title>';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '</head>';
echo '<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>';
echo '<script language=javascript>';
echo 'function submitPostLink()';
echo '{';
echo 'document.postlink.submit();';
echo '}';
echo '</script>';

echo '<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">';
echo '<link href="my.css" rel="stylesheet">';

echo '<div class="panel panel-default">USB Usage :';
echo '<div class="panel-body">';
echo '<div class="progress">';
echo '<div class="progress-bar progress-bar-warning" role="progressbar" style="width:'.$size.'">'.$size.'</div>';
echo '</div>';
echo '</div>';
echo '</div>';
//Record button
echo '<h1><center>Record Video or Capture Image</center></h1>';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-xs-6">'; 
echo '<a href="?action=Record" class="btn btn-info btn-large">Start Record</a>';
echo '</div>';
echo '<div class="col-xs-6">';
echo '<a href="?action=Capture" class="btn btn-info btn-large">Capture Image</a>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<br>';

//Image display
if ($imagedisplay != 'disabled')
{
$images = glob('/media/drive/images/*{.jpg}', GLOB_BRACE);
$count = 0;
if(!empty($images))
{
echo '<h1><center>Images</center></h1>';
}

echo '<div class="container">';
echo '<div class="row">';
foreach ($images as $image)
{
echo '<div class="col-md-4">';
echo '<center><a href="?deleteimg='.basename($image).'" class="btn btn-danger btn-small">Delete</a></center>';
echo '<a href="/media/drive/images/'.basename($image).'" class="thumbnail">';
echo '<center><p>'.basename($image).'</p></center>';
echo '<img src="/media/drive/images/'.basename($image).'" alt="'.basename($image).'" class="img-responsive">';
echo '</a>';
echo '</div>';
$count = $count + 1;
if($count == 3)
{
echo '</div>';
echo '<div class="row">';
$count = 0;
}
} 
echo '</div>';
echo '</div>';
}


if ($videodisplay != 'disabled')
{
//Video streaming
$count = 0;

$videos = glob('/media/drive/videos/*{.mp4}', GLOB_BRACE);
if(!empty($videos))
{
echo '<h1><center>Videos</center></h1>';
}
echo '<div class="container">';
echo '<div class="row">';
foreach ($videos as $video)
{
echo '<div class="col-md-6">';
echo '<div class="row" style="padding:5px 0px 0px 0px">';
echo '<center><h6 width="100%" style="background-color:lightblue">'.basename($video).'</h6></center>';
echo '</div>';
echo '<video src="/media/drive/videos/'.basename($video).'" controls width="100%"></video>';
echo '<center><a href="?delete='.basename($video).'" class="btn btn-danger btn-small">Delete</a></center>';
echo '</div>';
$count = $count + 1;
if($count == 2)
{
	echo '</div>';
	echo '<div class="row">';
	$count = 0;
}
}

echo '</div></div><br>';
}

echo '<br><br>';
//Footer
if(empty($videos) && empty($images))
{
echo '<h1><center>There is nothing to display. Try restarting</center></h1>';
}

echo '<footer>';
echo '<div class="modal-footer">';
echo '<a href="?action=Restart" class="btn btn-primary btn-large">Restart</a>';
echo '</div>';
echo '</footer>';
echo '<script src="JQuery.js"></script>';
echo '<script src="bootstrap/dist/js/bootstrap.js"></script>';
echo '</html>';
?>
