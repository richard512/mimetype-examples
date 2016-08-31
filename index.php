<?php

$dirpath = 'filetypes/';
$dirlist = scandir($dirpath);
$filenames = array();
$mimetypes = array();
foreach ($dirlist as $file) {
	if ($file=='.' || $file=='..') continue;
	if (is_dir($dirpath.$file)) continue;
    $filenames[] = $file;
    $mimetypes[] = getMimeType($dirpath.$file);
}

array_multisort($mimetypes, $filenames);

echo '<h3>The sample files, sorted by MIME Type</h3>';
echo '<table>'."\n";
echo '<thead>';
echo '<th>File</th>';
echo '<th>MIME Type</th>';
echo '<th>Action</th>';
echo '</thead>';
echo '<tbody>' . "\n";
foreach ($filenames as $i => $file) {
    echo '<tr>';
    echo '<td>';
    echo '<a href="filetypes/'.$filenames[$i].'">';
    echo $filenames[$i];
    echo '</a>';
    echo '</td>';
    echo '<td>'.$mimetypes[$i].'</td>';
    echo '<td>'.makeHtml5Element('filetypes/'.$filenames[$i], $mimetypes[$i]).'</td>';
    echo '</td>'."\n";
}
echo '</tbody>';
echo '</table>';

function makeHtml5Element($filepath, $mimetype) {
    $arrmime = explode('/', $mimetype);
    if ($arrmime) {
        $mimeTopLevel = $arrmime[0];
        switch ($mimeTopLevel) {
            case 'application':
                return '<a href="'.$filepath.'">Download</a>';
                break;
            case 'audio':
                return '<audio controls src="'.$filepath.'"></audio>';
                break;
            case 'image':
                return '<div style="height:100px;width:100px;background:url('.$filepath.');background-size: contain;background-repeat: no-repeat;"></div>';
                break;
            case 'video':
                return '<video controls height="300px" width="400px" src="'.$filepath.'"></video>';
                break;
        }
    }
}

function getMimeType($tmpname)
{
    $mimetype = '';
    if (function_exists('finfo_fopen')) {
    	//echo 'using finfo_fopen';
        $finfo = new finfo();
        $mimetype = $finfo->file($tmpname,FILEINFO_MIME_TYPE);
    } elseif (function_exists('mime_content_type')) {
    	//echo 'using mime_content_type';
        $mimetype = mime_content_type($tmpname);
    } elseif (function_exists('getimagesize')) {
    	//echo 'using getimagesize';
        $mimetype = getimagesize($tmpname);
    } elseif (function_exists('exif_imagetype')) {
    	//echo 'using exif_imagetype';
        $mimetype = exif_imagetype($tmpname);
    }
    return $mimetype;
}

?>

<style type="text/css">
    table {
        border-collapse: collapse;
        text-align: left;
    }
    th, td {
        border: 1px solid #eaeaea;
        padding: 10px;
    }
</style>