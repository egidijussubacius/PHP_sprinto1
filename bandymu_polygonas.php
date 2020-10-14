<?php
// file download 
if(isset($_POST['download'])){
    $file='./' . $_GET["path"] . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    print($fileToDownloadEscaped);

    header('Content-Description: File Transfer');
    header('Content-Type: application/');
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));

    flush();
    readfile($fileToDownloadEscaped);
    exit;
}

?>

<h2>File manager Program</h2>
<form action="<?php $path ?>" method="POST">
        <label for="name">Create new directory</label>
        <br>
        <input type="text" id="name" name="name" placeholder="Enter new directory name">
        <button type="submit">Create</button>
    </form>
    <form class="inline" action="" method="POST" enctype="multipart/form-data">
        <h3>Upload File</h3>
            <input type="file" name="file">
                <input  type="submit" value="upload" name="upload">
           
            </form>
    <?php
$path = "./" . $_GET['path'];
if (isset($_POST['name'])) {
    mkdir($path . "/" . ($_POST['name']));
}
if (array_key_exists('file', $_GET)) {
    unlink($path . "/" . $_GET['file']);
}
$dir_contents = scandir($path);
echo("<table id='table'><thead><tr>
<th>Type</th> 
<th>Name</th> 
 <th>Actions</th>
  </tr></thead>");
echo("<tbody><tr>");

foreach ($dir_contents as $cont) {
    echo("<tr><td>" . (is_dir($path . "/" . $cont) ? "Dir" : "File") . "</td>");
    if (is_dir($path . "/" . $cont)) {
        echo("<td>" . "<a href='./?path=" . $_GET['path'] . "/" . $cont . "'>" . $cont . "</a> </td>");
    } else {
        echo("<td>"  . $cont . "</td>");
    }
    if (is_file ($path . "/" . $cont)) {
        echo ("<td>  <button><a href='deleteFile.php?name=$cont'> Delete</button>   </td>");
        print '<td><form style="display: inline-block" action="" method="post">
                <input type="hidden" name="download" value='.$cont.'>
                <input class="middle" type="submit" value="Download">
               </form></td>';
    } else {
        echo("<td></td>");
    }
       
    }
    echo('<tbody></table>');
    $back = explode("/", $_GET['path']);
        $backString = "";
        for ($i = 0; $i < count($back) - 1; $i++) {
            if($back[$i] == "")
            continue;
            $backString .= "/" . $back[$i];
        }
        echo("<button>" . "<a href='./?path=" . $backString . "'>" . "BACK" . "</a>" . "</button>");
    
    ?>