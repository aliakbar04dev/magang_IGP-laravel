<?php

//https://github.com/laravel-notification-channels/telegram
//https://telegram-bot-sdk.readme.io/docs
//https://api.telegram.org/bot148103224:AAGCRuNetAhTJ88ckP-o9O4-zRcSh1Nwolg/setWebhook?url=https://iaess.igp-astra.co.id/telegram/botigps/webhooks
//https://api.telegram.org/bot148103224:AAGCRuNetAhTJ88ckP-o9O4-zRcSh1Nwolg/setWebhook?url=
//https://api.telegram.org/bot249661238:AAEewCCbLBrScwoY0vizB_4NBwZ2t8lxR6Q/setWebhook?url=https://iaess.igp-astra.co.id/telegram/botigps/webhooks2
//https://api.telegram.org/bot249661238:AAEewCCbLBrScwoY0vizB_4NBwZ2t8lxR6Q/setWebhook?url=

function commandDefault(){
    $balas = "Anda dapat mengontrol saya dengan mengirim perintah ini:\n\n";
    $balas.= "/id - mendapatkan id telegram anda\n";
    $balas.= "/profile - mendapatkan profile anda\n";
    $balas.= "/cuti - cek saldo cuti\n";
    $balas.= "/obat - cek saldo obat\n";
    $balas.= "/kacamata - cek batas klaim kacamata\n";
    $balas.= "/help - bantuan\n";
    return $balas;
}

function commandDefaultSupplier(){
    $balas = "Anda dapat mengontrol saya dengan mengirim perintah ini:\n\n";
    $balas.= "/id - mendapatkan id telegram anda\n";
    $balas.= "/profile - mendapatkan profile anda\n";
    $balas.= "/invoice - cek status invoice\n";
    $balas.= "/help - bantuan\n";
    return $balas;
}

function logout($file, $npk){
    try {
        if (!file_exists($file)) {
            fopen($file,"w");
            // chmod($file, 0775);
            $text = "step=login&npk=".$npk;
            $handle = @fopen($file, "w+");
            if ($handle) {
                file_put_contents($file, $text, FILE_APPEND);
                fclose($handle);
            }
        } else {
            $text = "step=login&npk=".$npk;
            // chmod($file, 0775);
            $handle = @fopen($file, "w+");
            if ($handle) {
                file_put_contents($file, $text, FILE_APPEND);
                fclose($handle);
            }
        }
        $balas = "Logout berhasil.";
        return $balas;
    } catch (Exception $ex) {
        $balas = "Logout gagal.";
        return $balas;
    }
}

//Fungsi untuk Penyederhanaan kirim perintah dari URI API Telegram
function BotKirim($perintah, $token){
    return 'https://api.telegram.org/bot'.$token.'/'.$perintah;
}

/*  Perintah untuk mendapatkan Update dari Api Telegram.
 *  Fungsi ini menjadi penting karena kita menggunakan metode "Long-Polling".
 *  Jika Anda menggunakan webhooks, fungsi ini tidaklah diperlukan lagi.
 */
function DapatkanUpdate($offset, $token) {
    //kirim ke Bot
    $perintah = "getUpdates";
    $url = BotKirim($perintah, $token)."?offset=".$offset;
    //dapatkan hasilnya berupa JSON
    $kirim = file_get_contents($url);
    //kemudian decode JSON tersebut
    $hasil = json_decode($kirim, true);
    if ($hasil["ok"] == 1) {
        /* Jika hasil["ok"] bernilai satu maka berikan isi JSONnya.
         * Untuk dipergunakan mengirim perintah balik ke Telegram
         */
        return $hasil["result"];
    } else {   
        /* Jika tidak maka kosongkan hasilnya.
        * Hasil harus berupa Array karena kita menggunakan JSON.
        */
        return array();
    }
}

/* Fungsi untuk mengirim "perintah" ke Telegram
* Perintah tersebut bisa berupa
*  -SendMessage = Untuk mengirim atau membalas pesan
*  -SendSticker = Untuk mengirim pesan
*  -Dan sebagainya, Anda bisa memm
* 
* Adapun dua fungsi di sini yakni pertama menggunakan
* stream dan yang kedua menggunkan curl
* 
* */
function KirimPerintahStream($perintah, $token, $data) {
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents(BotKirim($perintah, $token), false, $context);
    return $result;
}

function KirimPerintahCurl($perintah, $token, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, BotKirim($perintah, $token));
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $kembali = curl_exec($ch);
    curl_close ($ch);

    return $kembali;
}

function KirimPerintah($perintah, $token, $data) {
    // Detek otomatis metode curl atau stream (by Radya)
    if(is_callable('curl_init')) {
        $hasil = KirimPerintahCurl($perintah, $token, $data);
        //cek kembali, terkadang di XAMPP Curl sudah aktif
        //namun pesan tetap tidak terikirm, maka kita tetap gunakan Stream
        if (empty($hasil)){
            $hasil = KirimPerintahStream($perintah, $token, $data);
        }
    } else {
        $hasil = KirimPerintahStream($perintah, $token, $data);
    }
    return $hasil;
}

/* Fungsi untuk mengirim "perintah" ke Telegram
 * Perintah tersebut bisa berupa
 *  -SendMessage = Untuk mengirim atau membalas pesan
 *  -SendSticker = Untuk mengirim pesan
 *  -Dan sebagainya
 * 
 * */
function sendMessage($perintah, $token, array $keterangan = null){
    try {
        $url = BotKirim($perintah, $token)."?";
        foreach ($keterangan as $k => $v) {
            $url.=$k."=".$v."&";
        }
        $url = rtrim($url,"&");
        $result = file_get_contents($url);
        return true;
    } catch (Exception $ex) {
        //echo "Send Message Error: ".$ex;
        return false;
    }
}

function readTextFile($file){
    $text = "ERROR";
    if (file_exists($file)) {
        $handle = @fopen($file, "r");
        if ($handle) {
            $i = 0;
            while (!feof($handle)) {
                if($i < 1) {
                    $buffer = fgets($handle, 1000000);
                    if($buffer != null) {
                        $text = $buffer;
                    }
                }
                $i++;
            }
            fclose($handle);
        }
    }
    return $text;
}

function writeTextFile($file, $text){
    try {
        if (!file_exists($file)) {
            fopen($file,"w");
            // chmod($file, 0775);
            $handle = @fopen($file, "w+");
            if ($handle) {
                file_put_contents($file, $text, FILE_APPEND);
                fclose($handle);
            }
        } else {
            // chmod($file, 0775);
            $handle = @fopen($file, "w+");
            if ($handle) {
                file_put_contents($file, $text, FILE_APPEND);
                fclose($handle);
            }
        }
        return true;
    } catch (Exception $ex) {
        return false;
    }
}