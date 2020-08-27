<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;
use Exception;
use App\Bot;

class BotIgpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $token_bot = config('app.token_igp_astra_bot', '-');

        // $offset  = 0; //mula-mula tepatkan nilai offset pada nol
        // $nama_file = "last_update_id";
        // $file = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR.$nama_file;

        // //cek file apakah terdapat file "last_update_id"
        // if (file_exists($file)) {
        //     //jika ada, maka baca offset tersebut dari file "last_update_id"
        //     $offset = (int)file_get_contents($file);
        // }
        
        // //baca JSON dari bot, cek dan dapatkan pembaharuan JSON nya
        // $updates = DapatkanUpdate($offset, $token_bot);

        // $updateLastId = "F";
        // foreach ($updates as $message) {

        //     $updateLastId = "T";
        //     $offset = $message["update_id"];;
        //     $message_data = $message["message"];
            
        //     //jika terdapat text dari Pengirim
        //     if (isset($message_data["text"])) {
        //         //User
        //         $user_id = $message_data["from"]["id"]; //  Integer     Unique identifier for this user or bot
        //         $user_first_name = $message_data["from"]["first_name"]; //String    User‘s or bot’s first name
        //         $user_last_name = "";
        //         if(isset($message_data["from"]["last_name"])) {
        //             $user_last_name = $message_data["from"]["last_name"]; //String  Optional. User‘s or bot’s last name
        //         }
        //         $user_username = "";
        //         if(isset($message_data["from"]["username"])) {
        //             $user_username = $message_data["from"]["username"]; //String    Optional. User‘s or bot’s username
        //         }

        //         //Chat
        //         $chat_id = $message_data["chat"]["id"]; //Integer   Unique identifier for this chat, not exceeding 1e13 by absolute value
        //         $chat_type = $message_data["chat"]["type"]; //String    Type of chat, can be either “private”, “group”, “supergroup” or “channel”
        //         //$chat_title =  $message_data["chat"]["title"]; //String   Optional. Title, for channels and group chats
        //         //$chat_username = $message_data["chat"]["username"]; //String  Optional. Username, for private chats and channels if available
        //         //$chat_first_name = $message_data["chat"]["first_name"]; //String  Optional. First name of the other party in a private chat
        //         //$chat_last_name = $message_data["chat"]["last_name"]; //String    Optional. Last name of the other party in a private chat

        //         //Message
        //         $message_id = $message_data["message_id"]; //Integer    Unique message identifier
        //         $message_text = $message_data["text"]; //String     Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters.
                
        //         //Contact
        //         //$contact_phone_number = $message_data["contact"]["phone_number"]; //String    Contact's phone number
        //         //$contact_first_name = $message_data["contact"]["first_name"]; //String    Contact's first name

        //         $fileLog = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."chat";
        //         // chmod($fileLog, 0775);
        //         $handleLog = @fopen($fileLog, "a+");
        //         if ($handleLog) {
        //             $send_date = Carbon::now()->format('d-m-Y H:i:s');
        //             $textLog = $send_date." - ".$user_id." - ".$user_first_name." - ".$chat_type." - ".$message_text."\n";
        //             file_put_contents($fileLog, $textLog, FILE_APPEND);
        //             fclose($handleLog);
        //         }

        //         if(strtoupper($chat_type) == strtoupper("private")) {
        //             /*
        //             $balas = "Phone Number: ".$user_username."\n\n";
        //             $balas.= "Phone Name: ".$user_last_name."\n";
        //             */

        //             $file_user = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$user_id;
        //             $st_login = "login";
        //             $st_npk = "00000";
        //             if (!file_exists($file_user)) {
        //                 $text = "step=login&npk=00000";
        //                 writeTextFile($file_user, $text);
        //             } else {
        //                 $informasi = readTextFile($file_user);
        //                 if($informasi != "ERROR") {
        //                     parse_str($informasi);
        //                     $st_login = $step;
        //                     $st_npk = $npk;
        //                 } else {
        //                     $st_login = "ERROR";
        //                 }
        //             }

        //             $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
        //             if(strtolower($st_login) == "ok") {

        //             } else {

        //             }

        //             $data = array(
        //                 'chat_id' => $chat_id,
        //                 'text'=> $balas,
        //                 'parse_mode'=>'Markdown', //Markdown or HTML
        //                 'reply_to_message_id' => $message_id
        //                 );

        //             $result = KirimPerintah("sendMessage", $token_bot, $data);
        //             if(!$result) {
        //                 echo "Send Message Error";
        //                 echo "<BR>";
        //             }
        //         }
        //     }
        // }
        // if($updateLastId == "T") {
        //     //tulis dan tandai updatenya yang nanti digunakan untuk nilai offset
        //     file_put_contents($file, $offset + 1);
        // }
        return view('errors.404');
    }

    // public function webhooks(Request $request) {
    //     $token_bot = config('app.token_igp_astra_bot', '-');

    //     $entityBody = file_get_contents('php://input');
    //     $message = json_decode($entityBody, true);
        
    //     $message_data = $message["message"];
            
    //     //jika terdapat text dari Pengirim
    //     if (isset($message_data["text"])) {
    //         //User
    //         $user_id = $message_data["from"]["id"]; //  Integer     Unique identifier for this user or bot
    //         $user_first_name = $message_data["from"]["first_name"]; //String    User‘s or bot’s first name
    //         $user_last_name = "";
    //         if(isset($message_data["from"]["last_name"])) {
    //             $user_last_name = $message_data["from"]["last_name"]; //String  Optional. User‘s or bot’s last name
    //         }
    //         $user_username = "";
    //         if(isset($message_data["from"]["username"])) {
    //             $user_username = $message_data["from"]["username"]; //String    Optional. User‘s or bot’s username
    //         }

    //         //Chat
    //         $chat_id = $message_data["chat"]["id"]; //Integer   Unique identifier for this chat, not exceeding 1e13 by absolute value
    //         $chat_type = $message_data["chat"]["type"]; //String    Type of chat, can be either “private”, “group”, “supergroup” or “channel”
    //         //$chat_title =  $message_data["chat"]["title"]; //String   Optional. Title, for channels and group chats
    //         //$chat_username = $message_data["chat"]["username"]; //String  Optional. Username, for private chats and channels if available
    //         //$chat_first_name = $message_data["chat"]["first_name"]; //String  Optional. First name of the other party in a private chat
    //         //$chat_last_name = $message_data["chat"]["last_name"]; //String    Optional. Last name of the other party in a private chat

    //         //Message
    //         $message_id = $message_data["message_id"]; //Integer    Unique message identifier
    //         $message_text = $message_data["text"]; //String     Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters.
            
    //         //Contact
    //         //$contact_phone_number = $message_data["contact"]["phone_number"]; //String    Contact's phone number
    //         //$contact_first_name = $message_data["contact"]["first_name"]; //String    Contact's first name

    //         $fileLog = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."chat";
    //         // chmod($fileLog, 0775);
    //         $handleLog = @fopen($fileLog, "a+");
    //         if ($handleLog) {
    //             $send_date = Carbon::now()->format('d-m-Y H:i:s');
    //             $textLog = $send_date." - ".$user_id." - ".$user_first_name." - ".$chat_type." - ".$message_text."\n";
    //             file_put_contents($fileLog, $textLog, FILE_APPEND);
    //             fclose($handleLog);
    //         }

    //         if(strtoupper($chat_type) == strtoupper("private")) {
    //             /*
    //             $balas = "Phone Number: ".$user_username."\n\n";
    //             $balas.= "Phone Name: ".$user_last_name."\n";
    //             */

    //             $file_user = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$user_id;
    //             $st_login = "login";
    //             $st_npk = "00000";
    //             if (!file_exists($file_user)) {
    //                 $text = "step=login&npk=00000";
    //                 writeTextFile($file_user, $text);
    //             } else {
    //                 $informasi = readTextFile($file_user);
    //                 if($informasi != "ERROR") {
    //                     parse_str($informasi);
    //                     $st_login = $step;
    //                     $st_npk = $npk;
    //                 } else {
    //                     $st_login = "ERROR";
    //                 }
    //             }

    //             $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    //             if(strtolower($st_login) == "ok") {
    //                 if(strtoupper($message_text) == strtoupper("/start") || strtoupper($message_text) == strtoupper("/login")) {
    //                     $balas = "Input NPK: ";
    //                     $text = "step=password&npk=".$st_npk;
    //                     writeTextFile($file_user, $text);
    //                 } else if(strtoupper($message_text) == strtoupper("/help")) {
    //                     $balas = commandDefault();
    //                 } else if(strtoupper($message_text) == strtoupper("/id")) {
    //                     $balas = "ID Telegram Anda: ".$user_id;
    //                 } else if(strtoupper($message_text) == strtoupper("/cuti")) {
    //                     $bot = new Bot();
    //                     $balas = $bot->getSaldoCuti($st_npk);
    //                 } else if(strtoupper($message_text) == strtoupper("/obat")) {
    //                     $bot = new Bot();
    //                     $balas = $bot->getSaldoObat($st_npk);
    //                 } else if(strtoupper($message_text) == strtoupper("/kacamata")) {
    //                     $bot = new Bot();
    //                     $balas = $bot->getBatasKlaimKacamata($st_npk);
    //                 } else if(strtoupper($message_text) == strtoupper("/logout")) {
    //                     $balas = logout($file_user, $st_npk);
    //                 } else {
    //                     $balas = commandDefault();
    //                 }
    //             } else {
    //                 if(strtoupper($message_text) == strtoupper("/start") || strtoupper($message_text) == strtoupper("/login")) {
    //                     $balas = "Input NPK: ";
    //                     $text = "step=password&npk=".$st_npk;
    //                     writeTextFile($file_user, $text);
    //                 } else if(strtoupper($message_text) == strtoupper("/help")) {
    //                     $balas = commandDefault();
    //                 } else if(strtoupper($message_text) == strtoupper("/id")) {
    //                     $balas = "ID Telegram Anda: ".$user_id;
    //                 } else if(strtoupper($message_text) == strtoupper("/logout")) {
    //                     $balas = logout($file_user, $st_npk);
    //                 } else {
    //                     if($st_login == "login") {
    //                         $text = "step=password&npk=".$st_npk;
    //                         if(writeTextFile($file_user, $text)) {
    //                             $balas = "Input NPK: ";
    //                         } else {
    //                             $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    //                         }
    //                     } else if($st_login == "password") {
    //                         $text = "step=verifikasi&npk=".$message_text;
    //                         if(writeTextFile($file_user, $text)) {
    //                             $balas = "Input Password Intranet: ";
    //                         } else {
    //                             $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    //                         }
    //                     } else if($st_login == "verifikasi") {
    //                         $user_intranet = $st_npk;
    //                         $password_intranet = $message_text;

    //                         $bot = new Bot();
    //                         $balas = $bot->login($user_intranet, $password_intranet);
    //                         if($balas == "OK") {
    //                             $text = "step=ok&npk=".$st_npk;
    //                             if(writeTextFile($file_user, $text)) {
    //                                 $balas = commandDefault();
    //                             } else {
    //                                 $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    //                             }
    //                         }
    //                     } else {
    //                         $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
    //                     }
    //                 }
    //             }

    //             $data = array(
    //                 'chat_id' => $chat_id,
    //                 'text'=> $balas,
    //                 'parse_mode'=>'Markdown', //Markdown or HTML
    //                 'reply_to_message_id' => $message_id
    //                 );

    //             $result = KirimPerintah("sendMessage", $token_bot, $data);
    //             if(!$result) {
    //                 echo "Send Message Error";
    //                 echo "<BR>";
    //             }
    //         }
    //     }
    // }

    public function webhooks(Request $request) {
        $token_bot = config('app.token_igp_astra_bot', '-');

        $entityBody = file_get_contents('php://input');
        $message = json_decode($entityBody, true);
        
        $message_data = $message["message"];
            
        //jika terdapat text dari Pengirim
        if (isset($message_data["text"])) {
            //User
            $user_id = $message_data["from"]["id"]; //  Integer     Unique identifier for this user or bot
            $user_first_name = $message_data["from"]["first_name"]; //String    User‘s or bot’s first name
            $user_last_name = "";
            if(isset($message_data["from"]["last_name"])) {
                $user_last_name = $message_data["from"]["last_name"]; //String  Optional. User‘s or bot’s last name
            }
            $user_username = "";
            if(isset($message_data["from"]["username"])) {
                $user_username = $message_data["from"]["username"]; //String    Optional. User‘s or bot’s username
            }

            //Chat
            $chat_id = $message_data["chat"]["id"]; //Integer   Unique identifier for this chat, not exceeding 1e13 by absolute value
            $chat_type = $message_data["chat"]["type"]; //String    Type of chat, can be either “private”, “group”, “supergroup” or “channel”
            //$chat_title =  $message_data["chat"]["title"]; //String   Optional. Title, for channels and group chats
            //$chat_username = $message_data["chat"]["username"]; //String  Optional. Username, for private chats and channels if available
            //$chat_first_name = $message_data["chat"]["first_name"]; //String  Optional. First name of the other party in a private chat
            //$chat_last_name = $message_data["chat"]["last_name"]; //String    Optional. Last name of the other party in a private chat

            //Message
            $message_id = $message_data["message_id"]; //Integer    Unique message identifier
            $message_text = $message_data["text"]; //String     Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters.
            
            //Contact
            //$contact_phone_number = $message_data["contact"]["phone_number"]; //String    Contact's phone number
            //$contact_first_name = $message_data["contact"]["first_name"]; //String    Contact's first name

            $fileLog = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."chat";
            // chmod($fileLog, 0775);
            $handleLog = @fopen($fileLog, "a+");
            if ($handleLog) {
                $send_date = Carbon::now()->format('d-m-Y H:i:s');
                $textLog = $send_date." - ".$user_id." - ".$user_first_name." - ".$chat_type." - ".$message_text."\n";
                file_put_contents($fileLog, $textLog, FILE_APPEND);
                fclose($handleLog);
            }

            if(strtoupper($chat_type) == strtoupper("private")) {
                /*
                $balas = "Phone Number: ".$user_username."\n\n";
                $balas.= "Phone Name: ".$user_last_name."\n";
                */

                $user = DB::table("users")
                ->whereRaw("length(username) = 5")
                ->where("telegram_id", $user_id)
                ->first();

                $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
                if($user == null) {
                    $balas = "Maaf, ID Telegram Anda: <strong>".$user_id."</strong> belum terdaftar di sistem Kami. Silahkan update data ID Telegram Anda di <a href='".url('login')."'>".url('login')."</a>\n\n";
                    $balas .= "1. Login ke <a href='".url('login')."'>".url('login')."</a>\n";
                    $balas .= "2. Pilih menu Setting->View Profile\n";
                    $balas .= "3. Klik Update Profile\n";
                    $balas .= "4. Update ID Telegram Anda\n";
                    $balas .= "5. Klik Save";
                } else {
                    if(strtoupper($message_text) == strtoupper("/start")) {
                        $balas = "Anda terdaftar di sistem Kami dengan data sbb:\n\n";
                        $balas .= "Name: <strong>".$user->name."</strong>\n";
                        $balas .= "Username: <strong>".$user->username."</strong>\n";
                        $balas .= "Email: <strong>".$user->email."</strong>\n";
                        if($user->no_hp != null) {
                            $balas .= "No. HP: <strong>".$user->no_hp."</strong>\n";
                        }
                        $balas .= "ID Telegram: <strong>".$user->telegram_id."</strong>\n\n";
                        $balas .= commandDefault();
                    } else if(strtoupper($message_text) == strtoupper("/id")) {
                        $balas = "ID Telegram Anda: ".$user_id;
                    } else if(strtoupper($message_text) == strtoupper("/profile")) {
                        $balas = "Anda terdaftar di sistem Kami dengan data sbb:\n\n";
                        $balas .= "Name: <strong>".$user->name."</strong>\n";
                        $balas .= "Username: <strong>".$user->username."</strong>\n";
                        $balas .= "Email: <strong>".$user->email."</strong>\n";
                        if($user->no_hp != null) {
                            $balas .= "No. HP: <strong>".$user->no_hp."</strong>\n";
                        }
                        $balas .= "ID Telegram: <strong>".$user->telegram_id."</strong>";
                    } else if(strtoupper($message_text) == strtoupper("/cuti")) {
                        $bot = new Bot();
                        $balas = $bot->getSaldoCuti($user->username);
                    } else if(strtoupper($message_text) == strtoupper("/obat")) {
                        $bot = new Bot();
                        $balas = $bot->getSaldoObat($user->username);
                    } else if(strtoupper($message_text) == strtoupper("/kacamata")) {
                        $bot = new Bot();
                        $balas = $bot->getBatasKlaimKacamata($user->username);
                    } else if(strtoupper($message_text) == strtoupper("/help")) {
                        $balas = commandDefault();
                    } else {
                        $balas = "Maaf, Keyword tidak terdaftar di sistem Kami.\n\n";
                        $balas .= commandDefault();
                    }
                }

                $data = array(
                    'chat_id' => $chat_id,
                    'text'=> $balas,
                    'parse_mode'=>'HTML', //Markdown or HTML
                    'reply_to_message_id' => $message_id
                    );

                $result = KirimPerintah("sendMessage", $token_bot, $data);
                if(!$result) {
                    echo "Send Message Error";
                    echo "<BR>";
                }
            }
        }
    }

    public function webhooks2(Request $request) {
        $token_bot = config('app.token_igp_group_bot', '-');

        $entityBody = file_get_contents('php://input');
        $message = json_decode($entityBody, true);
        
        $message_data = $message["message"];
            
        //jika terdapat text dari Pengirim
        if (isset($message_data["text"])) {
            //User
            $user_id = $message_data["from"]["id"]; //  Integer     Unique identifier for this user or bot
            $user_first_name = $message_data["from"]["first_name"]; //String    User‘s or bot’s first name
            $user_last_name = "";
            if(isset($message_data["from"]["last_name"])) {
                $user_last_name = $message_data["from"]["last_name"]; //String  Optional. User‘s or bot’s last name
            }
            $user_username = "";
            if(isset($message_data["from"]["username"])) {
                $user_username = $message_data["from"]["username"]; //String    Optional. User‘s or bot’s username
            }

            //Chat
            $chat_id = $message_data["chat"]["id"]; //Integer   Unique identifier for this chat, not exceeding 1e13 by absolute value
            $chat_type = $message_data["chat"]["type"]; //String    Type of chat, can be either “private”, “group”, “supergroup” or “channel”
            //$chat_title =  $message_data["chat"]["title"]; //String   Optional. Title, for channels and group chats
            //$chat_username = $message_data["chat"]["username"]; //String  Optional. Username, for private chats and channels if available
            //$chat_first_name = $message_data["chat"]["first_name"]; //String  Optional. First name of the other party in a private chat
            //$chat_last_name = $message_data["chat"]["last_name"]; //String    Optional. Last name of the other party in a private chat

            //Message
            $message_id = $message_data["message_id"]; //Integer    Unique message identifier
            $message_text = $message_data["text"]; //String     Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters.
            
            //Contact
            //$contact_phone_number = $message_data["contact"]["phone_number"]; //String    Contact's phone number
            //$contact_first_name = $message_data["contact"]["first_name"]; //String    Contact's first name

            $fileLog = public_path().DIRECTORY_SEPARATOR.'telegram'.DIRECTORY_SEPARATOR."chat_supplier";
            // chmod($fileLog, 0775);
            $handleLog = @fopen($fileLog, "a+");
            if ($handleLog) {
                $send_date = Carbon::now()->format('d-m-Y H:i:s');
                $textLog = $send_date." - ".$user_id." - ".$user_first_name." - ".$chat_type." - ".$message_text."\n";
                file_put_contents($fileLog, $textLog, FILE_APPEND);
                fclose($handleLog);
            }

            if(strtoupper($chat_type) == strtoupper("private")) {
                /*
                $balas = "Phone Number: ".$user_username."\n\n";
                $balas.= "Phone Name: ".$user_last_name."\n";
                */

                $user = DB::table("users")
                ->whereRaw("length(username) > 5")
                ->where("telegram_id", $user_id)
                ->first();

                $balas = "Maaf, system error. Silahkan coba beberapa saat lagi.";
                if($user == null) {
                    $balas = "Maaf, ID Telegram Anda: <strong>".$user_id."</strong> belum terdaftar di sistem Kami. Silahkan update data ID Telegram Anda di <a href='".url('login')."'>".url('login')."</a>\n\n";
                    $balas .= "1. Login ke <a href='".url('login')."'>".url('login')."</a>\n";
                    $balas .= "2. Pilih menu Setting->View Profile\n";
                    $balas .= "3. Klik Update Profile\n";
                    $balas .= "4. Update ID Telegram Anda\n";
                    $balas .= "5. Klik Save";
                } else {
                    if(strtoupper($message_text) == strtoupper("/start")) {

                        $explode = explode(".", $user->username);
                        $kd_supp = $explode[0];
                        $kd_supp = strtoupper($kd_supp);
                        
                        $nm_supp = DB::table("b_suppliers")
                        ->select(DB::raw("nama"))
                        ->where(DB::raw("kd_supp"), "=", $kd_supp)
                        ->value("nama");
                        if($nm_supp == null) {
                            $nm_supp = "-";
                        }

                        $balas = "Anda terdaftar di sistem Kami dengan data sbb:\n\n";
                        $balas .= "Name: <strong>".$user->name."</strong>\n";
                        $balas .= "Username: <strong>".$user->username."</strong>\n";
                        $balas .= "Email: <strong>".$user->email."</strong>\n";
                        if($user->no_hp != null) {
                            $balas .= "No. HP: <strong>".$user->no_hp."</strong>\n";
                        }
                        $balas .= "ID Telegram: <strong>".$user->telegram_id."</strong>\n";
                        $balas .= "Kode Supplier: <strong>".$kd_supp."</strong>\n";
                        $balas .= "Nama Supplier: <strong>".$nm_supp."</strong>\n\n";
                        $balas .= commandDefaultSupplier();
                    } else if(strtoupper($message_text) == strtoupper("/id")) {
                        $balas = "ID Telegram Anda: ".$user_id;
                    } else if(strtoupper($message_text) == strtoupper("/profile")) {
                        $explode = explode(".", $user->username);
                        $kd_supp = $explode[0];
                        $kd_supp = strtoupper($kd_supp);
                        
                        $nm_supp = DB::table("b_suppliers")
                        ->select(DB::raw("nama"))
                        ->where(DB::raw("kd_supp"), "=", $kd_supp)
                        ->value("nama");
                        if($nm_supp == null) {
                            $nm_supp = "-";
                        }

                        $balas = "Anda terdaftar di sistem Kami dengan data sbb:\n\n";
                        $balas .= "Name: <strong>".$user->name."</strong>\n";
                        $balas .= "Username: <strong>".$user->username."</strong>\n";
                        $balas .= "Email: <strong>".$user->email."</strong>\n";
                        if($user->no_hp != null) {
                            $balas .= "No. HP: <strong>".$user->no_hp."</strong>\n";
                        }
                        $balas .= "ID Telegram: <strong>".$user->telegram_id."</strong>\n";
                        $balas .= "Kode Supplier: <strong>".$kd_supp."</strong>\n";
                        $balas .= "Nama Supplier: <strong>".$nm_supp."</strong>";
                    } else if(strtoupper($message_text) == strtoupper("/invoice")) {
                        $balas = "Maaf, untuk sementara fitur tsb belum bisa digunakan.";
                    } else if(strtoupper($message_text) == strtoupper("/help")) {
                        $balas = commandDefaultSupplier();
                    } else {
                        $balas = "Maaf, Keyword tidak terdaftar di sistem Kami.\n\n";
                        $balas .= commandDefaultSupplier();
                    }
                }

                $data = array(
                    'chat_id' => $chat_id,
                    'text'=> $balas,
                    'parse_mode'=>'HTML', //Markdown or HTML
                    'reply_to_message_id' => $message_id
                    );

                $result = KirimPerintah("sendMessage", $token_bot, $data);
                if(!$result) {
                    echo "Send Message Error";
                    echo "<BR>";
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
