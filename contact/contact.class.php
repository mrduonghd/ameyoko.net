<?php
class Contact
{
    public static function check_input($name, $email, $message)
    {
        $arr_err_msg = array(
            'name' => '',
            'email' => '',
            'message' => ''
        );

        if ((!isset($name) || $name == "")) {
            $arr_err_msg['name'] = "お名前は必ず入力してください";
        }
        if ((!isset($email) || $email == "")) {
            $arr_err_msg['email'] = "メールアドレスは必ず入力してください";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $arr_err_msg['email'] = "メールアドレスは正しいフォーマットで入力してください";
        }
        if ((!isset($message) || $message == "")) {
            $arr_err_msg['message'] = "お問い合わせ内容は必ず入力してください";
        }
        return $arr_err_msg;
    }

    public static function send_contact_mail()
    {
        $name     = $_SESSION['contact-name'];
        $email    = $_SESSION['contact-email'];
        $body     = $_SESSION['contact-message'];
        $to       = 'ass@ameyoko.net';
        $subject  = 'アメ横公式サイトのお問い合わせフォームより送信されました';
        $message  = <<< EOD
        お客様より以下の内容がアメ横公式サイトのお問い合わせフォームより送信されました。
        ────────────────────────────────────
        [氏名]
        $name

        [メールアドレス]
        $email

        [メッセージ]
        $body

        ────────────────────────────────────
        EOD;

        $headers = "FROM: admin@ameyoko.net";
        $from_email = "admin@ameyoko.net";
        $additional_parameter  = "-f$from_email";

        return mb_send_mail($to, $subject, $message , $headers, $additional_parameter);

    }
}
