<?php
class MailController
{
    public function send($data)
    {
        global $db, $db_x, $cfg;
        $EOL = "\r\n";
        $boundary     = "-------" . md5(uniqid(time()));
        //TODO : добавить загрузку атачей в автоматическом режиме
        $path       = 'datas/users/';
        $fileArr = array("Акция ИБП. Наличие на складе.pdf", "Акция ДГУ. Наличие на складе.pdf");
        // $imagesArr = array("img1.jpg","img2.jpg","img3.jpg");
        $subject    = 'Предложение от компании «НОЙХАУС»';
        $subject    = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $sql_email_string = "SELECT contacts.* FROM {$db_x}komus_contacts contacts                               
                                WHERE id = {$contact_id} AND contacts.is_finish = 1";
        $sql_email = $db->query($sql_email_string);
        foreach ($sql_email as $key => $row) {
            if ($row['is_kp'] == 10) {
                $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 4.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width" />
            <title>Title</title>
        </head>
        <body style = "font: 11pt Arial; line-height: 1.5; font-style: italic;">
                Добрый день!<br><br>
                В продолжение нашего разговора по телефону, направляю Вам информацию о компании<br>
                &nbsp;&nbsp;&nbsp;&nbsp;1. В виде каталогов ИБП и ДГУ. 2 файла в приложении<br>
                &nbsp;&nbsp;&nbsp;&nbsp;2. Ссылка на наш сайт: <a href="http://neuhaus.ru/"> http://neuhaus.ru/ </a><br>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;В приложении находятся складские остатки по оборудованию ДГУ и ИБП. Стоимость можно уточнить у менеджеров отдела продаж.<br> 
                <br>
                На текущий момент Группа компаний Нойхаус является инжиниринговой компанией, которая предлагает своим Заказчикам решения по реализации инженерных проектов в области энергетики любой сложности. В состав этих решений входят проектные, монтажные и сервисные работы, а также поставка ДГУ, ИБП и ГПУ.
                <br>
                <br>
                Хорошего дня!
        </body>
    </html>';
                $to = $row['email_lpr'];
                $headers = "Mime-Version: 1.0$EOL";
                $headers = "From: info@neuhaus.ru$EOL";
                //  $headers .= "To: $to$EOL";
                //  $headers .= "Bcc: dmitriy@stakhanovets.ru,konstantin.shishlov@stakhanovets.ru$EOL";
                $headers .= "X-Mailer: PHPMail Tool$EOL";
                $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
                $multipart = $EOL;
                $multipart .= "--$boundary\n";
                $multipart .= "Content-Type: text/html; charset=\"utf-8\"\n";
                $multipart .= "Content-Transfer-Encoding: 8bit";
                $multipart .= "\n\n"; // раздел между заголовками и телом html-части
                $multipart .= $html;
                foreach ($fileArr as $file) {
                    $multipart .= "\n\n";
                    $multipart .= "--$boundary\n";
                    $multipart .= "Content-Type: application/octet-stream;\n name=\"" . $file . "\"\n";
                    $multipart .= "Content-Transfer-Encoding: base64\n";
                    $multipart .= "Content-Disposition: attachment;\n filename=\"" . $file . "\"\n";
                    $multipart .= "\n\n";
                    $multipart .= chunk_split(base64_encode(readFileForEmail($path . $file)));
                }
                $multipart .= "--$boundary--";
                if (mail($to, $subject, $multipart, $headers)) {
                    echo '<div style=\"padding: 10px\">Письмо отправлено</div>';
                } else {
                    echo '<div style=\"padding: 10px\"><strong>Ошибка при отправке анкеты по электронной почты!</strong></div>';
                }
            }
        }
    }
}
