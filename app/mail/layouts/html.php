<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            table, tr, td, div{
                margin: 0px; padding: 0px;
            }
            div {
                font-family:tahoma; font-size:13px;color:blue;text-align:justify; text-indent:30px;
            }
            blockquote {
                color:blue; font-size:10px; font-style:italic; text-align:justify;
            }
            i {color: fuchsia; font-size:12px;}
        </style>
    </head>
    <body>
        <table width="580" cellspacing="0" cellpadding="0" border="0" style="font:11px Verdana,Arial,Helvetica,sans-serif;color:#333">
            <tbody>
                <tr><td align="left"><img style="max-width:250px;" src="https://gamecard.vn/uploads/logo5.png"/></td></tr>
                <tr><td>
                        <table cellspacing="0" cellpadding="0" border="0" style="border: 1px solid #bbb; margin: 10px; padding: 5px 10px; font:12px Verdana,Arial,Helvetica,sans-serif;color:#333;">
                            <!--<tr><td  style="padding: 5px 0;"><h2><?php //echo $myMail->subject; ?></h1></td></tr>
                            <tr><td>Dear <?php //echo $myMail->name; ?>!</td></tr>
                            <tr><td>&nbsp;</td></tr>-->
                            <tr><td>
                                    <table cellspacing="0" cellpadding="0" border="0" style="background: #E8F1FA;font:12px Verdana,Arial,Helvetica,sans-serif;color:#333; margin: 10px;padding: 5px 10px;"">
                                        <tr>
                                            <td>
                                                <?php $this->beginBody() ?>
                                                <?= $content ?>
                                                <?php $this->endBody() ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>Yours sincerely,</td></tr>
                            <tr><td>Gamecard</td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="background: #FF2A00; color: #fff; padding: 5px 10px;">
                        <table>
                            <tr><td style="font-weight: bold; color: yellow;"><u>CHÚ Ý:</u></td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td style="font-weight: bold;">1. Nếu đơn hàng > 100$ bạn vui lòng liên hệ với bộ phận support qua: </td></tr>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <!-- BEGIN TAG CODE - DO NOT EDIT! -->												<div><div id="proactivechatcontainerwh0me1vzht"></div><table style="border:0px; cellspacing:2px; cellpadding:2px;"><tr>												<td style="text-align:center;" id="swifttagcontainerwh0me1vzht"><div style="display: inline;" id="swifttagdatacontainerwh0me1vzht"></div></td> 												</tr><tr><td style="text-align:center;"><div style="MARGIN-TOP: 2px; WIDTH: 100%; TEXT-ALIGN: center;">												<span style="FONT-SIZE: 9px; FONT-FAMILY: Tahoma, Arial, Helvetica, sans-serif;"><span style="COLOR: #000000">  </span></span>												</div></td></tr></table></div> 												<script type="text/javascript">var swiftscriptelemwh0me1vzht=document.createElement("script");swiftscriptelemwh0me1vzht.type="text/javascript";var swiftrandom = Math.floor(Math.random()*1001); var swiftuniqueid = "wh0me1vzht"; var swifttagurlwh0me1vzht="http://demandvi.com/visitor/index.php?/gamecard/LiveChat/HTML/HTMLButton/cHJvbXB0dHlwZT1jaGF0JnVuaXF1ZWlkPXdoMG1lMXZ6aHQmdmVyc2lvbj00LjYyLjAuNDM5NCZwcm9kdWN0PUZ1c2lvbiZmaWx0ZXJkZXBhcnRtZW50aWQ9MTEmcm91dGVjaGF0c2tpbGxpZD0yJmN1c3RvbW9ubGluZT1odHRwJTNBJTJGJTJGZGVtYW5kdmkuY29tJTJGX19zd2lmdCUyRmZpbGVzJTJGZmlsZV9odTNhaTRsMm1xZTRzNHAuZ2lmJmN1c3RvbW9mZmxpbmU9aHR0cCUzQSUyRiUyRmRlbWFuZHZpLmNvbSUyRl9fc3dpZnQlMkZmaWxlcyUyRmZpbGVfNGN3MzM3dzg3MXB3NDgwLmdpZiZjdXN0b21hd2F5PWh0dHAlM0ElMkYlMkZkZW1hbmR2aS5jb20lMkZfX3N3aWZ0JTJGZmlsZXMlMkZmaWxlX3FlYWJxOXRvazVuMGY5eS5naWYmY3VzdG9tYmFja3Nob3J0bHk9aHR0cCUzQSUyRiUyRmRlbWFuZHZpLmNvbSUyRl9fc3dpZnQlMkZmaWxlcyUyRmZpbGVfNnhlM2ZicXlnaHU2YWJ2LmdpZgpiYjVlNGNmOTU4NzFjMzA5ZWZhZjBkZGI3ODExZGQyMzkzNzg5Y2Y0";setTimeout("swiftscriptelemwh0me1vzht.src=swifttagurlwh0me1vzht;document.getElementById('swifttagcontainerwh0me1vzht').appendChild(swiftscriptelemwh0me1vzht);",1);</script>												<!-- END TAG CODE - DO NOT EDIT! -->
                                            </td>
                                            <td>
                                                <p>&nbsp;&nbsp;&nbsp; - Email hỗ trợ mua hàng: <b style="color: red;">sale@gamecard.vn</b></p>
                                                <p>&nbsp;&nbsp;&nbsp; - Phone number: (USA) <b>1-408-844-4577</b> / (AUS) <b>61-03-9005-5699</b> / (AUS) <b>84-08-62672181</b></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>
                            <tr><td  style="font-weight: bold;">2. Bạn vui lòng nạp mã thẻ ngay sau khi nhận được email, nếu bạn chưa có nhu cầu dùng hết số thẻ bạn vui lòng liên hệ với bộ phận support để chúng tôi có thể cất giữ dùm bạn tránh trường hợp mã thẻ bị mất cắp</td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>( Xin lỗi bạn vì sự bất tiện này, chân thành cám ơn sự hợp tác của bạn )</td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td><a href="http://support.demandvi.com/visitor/index.php?/LiveChat/Chat/Request/_sessionID=5iw6y426lxty8448nxol4462wlu2d47w/_promptType=chat/_proactive=0/_languageID=4#">Support Online</a> | <a href="http://support.vnsupermark.com/index.php?/Tickets/Submit">Contact Us</a></td></tr>
                <tr><td>Please do not reply to this email because we are not monitoring this inbox.</td></tr>
                <tr><td>Copyright 2013 <a href="http://gamecard.vn">Gamecard.vn</a>. All rights reserved.</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>Gamecard Email ID Gamecardmail <?php //echo $myMail->id ?></td></tr>
                <tr><td>&nbsp;</td></tr>
            </tbody>
        </table>

    </body>
</html>
<?php $this->endPage() ?>
