<?php
/*
    This file by : @iven4
    My Channel : @iven4
*/
ob_start();
$API_KEY = "1550749344:AAGwu4mpRhLvmScPdQWxQOqsVWYdKJcDEd4"; // Add token
echo "api.telegram.org/bot$API_KEY/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME'];
define('API_KEY',$API_KEY);
//jj
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update   = json_decode(file_get_contents('php://input'));
$message  = $update->message;
$from_id  = $message->from->id;
$chat_id  = $message->chat->id;
$text     = $message->text;
$data     = $update->callback_query->data;
$inline   = $update->inline_query->query;
$id       = $update->inline_query->from->id;
$msg_id   = $update->inline_query->inline_message_id;
$username = $update->inline_query->from->username;
$cuser    = $update->callback_query->from->username;
$cid      = $update->callback_query->from->id;
if ($inline) {
    $ex = explode(" ", $inline);
    $user = trim($ex[0],"@");
    $wh = str_replace($ex[0], $wh, $inline);
    bot('answerInlineQuery',[
            'inline_query_id'=>$update->inline_query->id,    
            'results' => json_encode([[
                'type'=>'article',
                'id'=>base64_encode(rand(5,555)),
                'title'=>"هذه همسه سريه ل $user هو فقط من يستطيع روئيتها",
             'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"اهذه همسه سريه ل $user هو فقط من يستطيع روئيتها"],
            'reply_markup'=>['inline_keyboard'=>[
                [
                ['text'=>'اظغط للرؤيه','callback_data'=>$user."or".$username."or".$wh]
                ],
             ]]
          ]])
        ]);
}
if ($data) {
    $ex = explode("or", $data);

    if (preg_match('/^('.$ex[0].')/i', $cuser) or preg_match('/^('.$ex[01].')/i', $cuser) or $cid == $ex[0]) {
        bot('answerCallbackQuery',[
            'callback_query_id'=>$update->callback_query->id,
            'text'=>$ex[2],
            'show_alert'=>true
            ]);
    }else {
        bot('answerCallbackQuery',[
            'callback_query_id'=>$update->callback_query->id,
            'text'=>"الرساله ليست لك",
            'show_alert'=>true
            ]);
    }
}
if ($text == "/start") {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"مرحبا
🌐 انا بوت اهمسلي.

💬 يمكنك استخدامي لارسال رسائل سرية (همسات) في اي مجموعة تشاء.
  
🔮 انا اعمل عن بعد, هذا يعني انك تستيط استخدامي دون الحاجة لوجودي في المجموعة.

💌 طريقة استخدامي سهلة جداً, قم بتحويل اي رسالة من الشخص الذي تريد ان تهمس له هنا

هناك طرق اخرى للاستخدام يمكنك رؤيتها عبر الضغط على طرق اخرى لاستخدام البوت",
        'reply_markup'=>json_encode([
            [['text'=>"المطور","url"=>"t.me/iven4"]]
            ])
        ]);
}

/*
    This file by : @iven4
    My Channel : @iven4
*/
