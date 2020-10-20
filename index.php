
<html>

<?php 
    session_start(); 

    // logout
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
    }
    //log in
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {	
       if ($_POST['username'] == 'admin' && $_POST['password'] == '1') {
          $_SESSION['logged_in'] = true;
          $_SESSION['username'] = 'admin';
       } else {
          $msg = 'Wrong username or password';
       }
    }
?>

<head>
    <title>File manager E.S v1.1</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>

<?php
//file upload
$path = "./" . $_GET['path'];
    if(isset($_POST['upload'])){
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $file_store = ($path . '/') .$file_name;
        move_uploaded_file($file_tmp,$file_store);
    }
?>

<?php
// file download 

if (array_key_exists('action', $_GET)) {    
    if (array_key_exists('file', $_GET)) {
            $file = "./" . $_GET['path'] . "./" . $_GET['file'];
        if ($_GET['action'] == 'trinti') {
            unlink($path . "/" . $_GET['file']);
        } elseif ($_GET['action'] == 'atsiusti') {
            $fileDown = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
            ob_clean();
            ob_flush();
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . basename($fileDown));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileDown));
            ob_end_flush();
            readfile($fileDown);
            exit;
        }
    }
}
?>

<div>
         <?php
            $msg = '';
            if (isset($_POST['login']) 
                && !empty($_POST['username']) 
                && !empty($_POST['password'])
            ) {	
               if ($_POST['username'] == 'admin' && 
                  $_POST['password'] == '1'
                ) {
                  $_SESSION['logged_in'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'admin';
               } else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      
      <?php 
            if($_SESSION['logged_in'] == false){
                print('<form class="" id="prisijungimo" action = "" method = "post">' );
                print('<h4>' . $msg . '</h4>');
                print('<h4>Log In </h4>');
                print('<input type = "text" name = "username" placeholder = "username = admin" required autofocus></br>');
                print('<input type = "password" name = "password" placeholder = "password = 1" required><br>');
                print('<button class = "button" type = "submit" name = "login">Login</button>');
                print('</form>');
                die();
            }
            
        ?>
        
        <form action = "" method = "post" id="prisijungimo">
            <h3>Logged In!</h3>
            <h4><?php echo $msg; ?></h4>
            Click here to <a href = "index.php?action=logout"> logout.</a>
        </form>

            
        </div>
    <h1>File manager Program </h1>



    
   
<form action="<?php $path ?>" method="POST" class="login1"  >
        <label for="name">Create new directory</label>
        <br>
        <input type="text" id="name" name="name" placeholder="Enter new directory name">
        <button type="submit">Create</button>
    </form>
    <form  class="login2" action="" method="POST" enctype="multipart/form-data">
        <h3>Upload File</h3>
            <input type="file" name="file" id="tekstas2">
                <input  type="submit" value="upload" name="upload">
           
            </form>
          
    <?php
$path = "." . $_GET['path'];
if (isset($_POST['name'])) {
    mkdir($path . "/" . ($_POST['name']));
}
// if (array_key_exists('file', $_GET)) {
//     unlink($path . "/" . $_GET['file']);
// }
$dir_contents = scandir($path);
echo("<table id='table'><thead><tr>
<th>Type</th> 
<th>Name</th> 
 <th>Actions(Delete, Download)</th>
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
        if ($cont != "index.php") {
            echo ("<td><button id='mygtukasDEL'><a id='raides' href='./?path=" . $_GET['path'] . "&file=" . $cont . "&action=trinti" . "'>" . "Delete</a></button><button class='mygtukasDown'><a href='./?path=" . $_GET['path'] . "&file=" . $cont ."&action=atsiusti" . "'>" . "Download</a></button></td>");
        } else {
        
            echo ("<td></td>");
     
        }
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




</table>
</body>
</html>