<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ovning4.php" method="POST">
    Förnamn: <input type="text" name="firstname">
    <br><br>
    Efternamn: <input type="text" name="lastname">
    <br><br>
    Klass: <input type="text" name="class">
    <br><br>
    <div>
        Vad är din favorit mat?
        <input type="checkbox" name="food[]" value="potatis"> Potatis
        <input type="checkbox" name="food[]" value="kött"> Kött
        <input type="checkbox" name="food[]" value="ben"> Ben
        <input type="checkbox" name="food[]" value="KÖTT"> KÖTT
        <input type="checkbox" name="food[]" value="öga"> Öga
    </div>
    
    
    <br><br>
    <div>
        Vad är ditt favorit ämne? <br>
       <input type="radio" name="kurs" value="kemi"> Kemi <br>
       <input type="radio" name="kurs" value="religion"> Religion <br>
       <input type="radio" name="kurs" value="samhälle"> Samhälle <br>
       <input type="radio" name="kurs" value="matte"> Matte <br>
       <input type="radio" name="kurs" value="lunch"> Lunch <br>
    </div>
       
       
    <br><br>
    <input type="submit" value="submit">
    </form>
</body>
</html>