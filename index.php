<?php

echo '<table>'."\n";
$dirlist = scandir('.');
foreach ($dirlist as $file) {
	if ($file=='.' || $file=='..') continue;
	if (is_dir($file)) continue;
	echo '<tr><td>'.$file.'</td><td>'.getMimeType($file).'</td></td>'."\n";
}
echo '</table>';


function getMimeType($tmpname)
{
    $mimetype = '';
    if (function_exists('finfo_fopen')) {
    	echo 'using finfo_fopen';
        $finfo = new finfo();
        $mimetype = $finfo->file($tmpname,FILEINFO_MIME_TYPE);
    } elseif (function_exists('mime_content_type')) {
    	echo 'using mime_content_type';
        $mimetype = mime_content_type($tmpname);
    } elseif (function_exists('getimagesize')) {
    	echo 'using getimagesize';
        $mimetype = getimagesize($tmpname);
    } elseif (function_exists('exif_imagetype')) {
    	echo 'using exif_imagetype';
        $mimetype = exif_imagetype($tmpname);
    }
    return $mimetype;
}

?>