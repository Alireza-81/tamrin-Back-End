<meta charset="utf-8"/>
<?php
$question = "";
$flag = 0;
$file = fopen("messages.txt", "r");
$arr = array();
$i = 0;
while(!feof($file)) {
    $line = fgets($file);
    $arr[$i] = $line;
    $i = $i + 1;
 }
$key = array_rand($arr,1);
$msg = $arr[$key];

$json = json_decode(file_get_contents('people.json'));
$array1 = array();
$j = 0;
foreach($json as $key => $value){
    $array1[$j] = $key;
    $j = $j + 1;
}
$boos = array_rand($array1,1);
$en_name = $array1[$boos];
$json = json_decode(file_get_contents('people.json'));
    foreach($json as $key => $value){
        if ($key == $en_name){
            $fa_name = $value;
        }
    }
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $question = $_POST["question"];
    $en_name = $_POST["person"];
    $json = json_decode(file_get_contents('people.json'));
        foreach($json as $key => $value){
            if ($key == $en_name){
                $fa_name = $value;
            }
        }
    $avval = "/^آیا/iu";
    $akhar = "/\?$/i";
    $end = "/؟$/u";
    if(!preg_match($avval, $question) && $question != ""){
        $msg="سوال درستی پرسیده نشده!";
        $flag  = 1;
    }
    elseif(! (preg_match($akhar, $question) || preg_match($end, $question)) && $question != ""){
        $msg="سوال درستی پرسیده نشده!";
        $flag = 1;
    }
    else{
        $code = hash('adler32' , $question." ".$en_name);
        if ($question == ""){
            $msg = 'سوال خود را بپرس!';
            $flag = 0;
            $en_name = $array1[$boos];
        $json = json_decode(file_get_contents('people.json'));
            foreach($json as $key => $value){
                if ($key == $en_name){
                $fa_name = $value;
        }
    }
        }   
        else{
            
           $flag = 1;
           $message_num = 16;
            $code = hexdec($code);
            $kilid = ($code % $message_num);
            $msg = $arr[$kilid];
        }
        
    }
}
else{
    $en_name = $array1[$boos];
    $json = json_decode(file_get_contents('people.json'));
foreach($json as $key => $value){
    if ($key == $en_name){
        $fa_name = $value;
    }
}
}
$porsesh = 'پرسش:';
if ($flag == 0){
    $porsesh = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label"><?php echo $porsesh ?> </span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post" action =" <?php echo $_SERVER['PHP_SELF'];?>">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                $json = json_decode(file_get_contents('people.json'));
                    foreach($json as $key => $value) {
                        if($en_name == $key){
                            echo "<option value= $key selected > $value </option>" ;
                        }
                        else{
                            echo "<option value= $key> $value </option>" ;
                        }
                    }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
      </form>
    </div>
</div>
</body>
</html>
