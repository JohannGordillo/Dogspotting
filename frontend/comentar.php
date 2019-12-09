<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Añadir comentario</title>
</head>
<body>
<form action="insertComentar.php" method="post">
    <?php
        // Se crean inputs ocultos para enviar la informacion de la llave y el perro
        $api_key = $_GET["key"];
        $dog_id = $_GET["dog_id"];
        echo  "<input type=\"hidden\" name=\"api_key\" value='$api_key'>";
        echo  "<input type=\"hidden\" name=\"dog_id\" value='$dog_id'>";
   ?>
    <p>
        <textarea name="texto" rows="10" cols="30"/>
    </p>
    <input type="submit" value="Enviar comentario">
    <label>Máximo 500 carácteres</label>
</form>
</body>
</html>