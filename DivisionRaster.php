<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Division Raster</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <style type="text/css">

    html,body{
        max-height: 160px;
        background-color: #f5f5f5;
    }
     form{
        margin: 50px 15px 0px 15px;
    }
    </style>
    <script type="text/javascript" src="paper.js"></script>
<?php
     error_reporting(E_ALL ^ E_NOTICE);

    for ($i=1; $i <10 ; $i++) { 
    
    //je génere le code js en php car nous allons travailler avec 9 canvas != 
    //qui recevrons chacun une modif != en js   
    
        switch ($i) {
            case '1':
                $grid="new Size(55, 55)";
                $size="2.91";
                break;
            
            // le plus grand est 55*55 car les calculs se font dans le browser et il ne faut pas quil crash
            //aussi cette resolution est la resol. minimal pour pouvoir distinguer limage (apres tests)
            //je crée des images de 160*160 car cest le nombre d'or un peu arrondi pour des calculs plus simples
            
            case '2':
                $grid="new Size(34, 34)";
                $size="4.7";
                break;

            case '3':
                $grid="new Size(21, 21)";
                $size="7.62";
                break;

            case '4':
                $grid="new Size(13, 13)";
                $size="12.3";
                break;

            case '5':
                $grid="new Size(8, 8)";
                $size="20";
                break;

            case '6':
                $grid="new Size(5, 5)";
                $size="32";
                break;

            case '7':
                $grid="new Size(3, 3)";
                $size="53.33";
                break;

            case '8':
                $grid="new Size(2, 2)";
                $size="80";
                break;

            case '9':
                $grid="new Size(1, 1)";
                $size="160";
                break;
            
            default:
                $grid="new Size(2, 2)";
                $size="80";
                break;
        }

    //cest en paper.js qui permet de calculer les images "pixélisées" 
    //a partir dune image manipulée dans des canvas
    
    echo "
    <script type=\"text/paperscript\" canvas=\"canvas".$i."\">

        // Create a raster item using the image tag with id='mona'
        var raster = new Raster('mona');

        raster.visible = false;
        // Space the cells by 120%:
        var spacing = 1.2;

        raster.size = ".$grid.";

        // The size of our grid cells:
        var gridSize = ".$size.";

        for (var y = 0; y < raster.height; y++) {
            for(var x = 0; x < raster.width; x++) {
                // Get the color of the pixel:
                var color = raster.getPixel(x, y);

                // Create a circle shaped path:
                var position = new Point(x, y) * gridSize;
                var radius = gridSize;
                var path = new Path.Rectangle(position, radius);

                // Set the fill color of the path to the color
                // of the pixel:
                path.fillColor = color;
            }
        }

        // Move the active layer to the center of the view:
        project.activeLayer.position = view.center;
            </script>
            
            ";

        }

//fonction pour sauvegarder le contenu des canvas en ajax 
//et les envoyer 1 a 1 a un fichier php qui crée 9png grace a un attibu $_get

echo "</head>
<script type=\"text/javascript\">

//cette fonction est tres inspiré de ce tuto:
//http://permadi.com/tutorial/save-canvas/test-save-html5-canvas.html
//modifié pour creer un envoi multiple

    function saveViaAJAX()
    {
       
        
        for (var i = 1; i < 10; i++) {
        
        //je recupere la valeur de chaque canvas
        var name= \"canvas\"+i;
        var testCanvas = document.getElementById(name);
       
        //console.log(testCanvas);
        var canvasData = testCanvas.toDataURL(\"image/png\");
        //console.log(canvasData);

        var ajax = new XMLHttpRequest();

        var url = 'testSave.php?a='+i;
        ajax.open(\"POST\", url,false);

        ajax.setRequestHeader('Content-Type', 'application/upload');
        ajax.send(canvasData ); 
        };

        //je redirige vers le fichier qui crée un gif animé a partir des 9 fichiers png créé

        document.location.href='gif.php';
        
    }

    </script>

<body>
    <canvas id=\"canvas1\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas2\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas3\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas4\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas5\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas6\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas7\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas8\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    <canvas id=\"canvas9\" width=\"160\" height=\"160\" style=\"display: none;\"></canvas>
    ";

if ($_POST['send']) {
 
//je  sauve limage envoyée en la renommant avec la bonne extension

 $uploads_dir= "uploads";

 $items=scandir('uploads');
foreach ($items as $key => $value) {
    $nbr= $key;
}

$fichier=pathinfo($_FILES['image']['name']);
$extension= '.'.$fichier['extension'];

 $name= "upload".$nbr.$extension;

 move_uploaded_file($_FILES['image']['tmp_name'], "$uploads_dir/$name");

     //pour les test locaux $image = "cat.jpg";

$image = 'uploads/'.$name;

// je demande confirmation pour declancher la fonction d'envoi du contenu des canvas
    echo "<img width=\"160\" height=\"160\" id=\"mona\" src=".$image.">
    <button onclick=\"saveViaAJAX();\">confirmer</button>";

    }
else {
    echo"<form method=\"post\" action=\"#\" enctype=\"multipart/form-data\">
            <label for=\"image\">Créer mon gif</label><input name=\"image\" id=\"image\" type=\"file\">
            <input type=\"submit\" name=\"send\" value=\"envoyer\">
        </form>";
   
}

?>
    <!-- for local debug <img width="300" height="512" id="mona" style="display: none;" src="cat.jpg"> -->
    
</body>
</html>