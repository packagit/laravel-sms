<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-27
 * Time: 23:04
 */

namespace Ibrand\Sms;

use Illuminate\Routing\Controller;
use Ibrand\Sms\Facade as Sms;

class SmsController extends Controller
{
    public function postSendCode()
    {
        $mobile = request('mobile');


        if (!Sms::canSend($mobile)) {
            return response()->json(['success' => 'false', 'message' => '每60秒发送一次']);
        }

        if (!Sms::send($mobile)) {
            return response()->json(['success' => 'false', 'message' => '短信发送失败']);
        }

        return response()->json(['success' => 'true', 'message' => '短信发送成功']);
    }

    public function info()
    {
        $html = '<meta charset="UTF-8"/><h2 align="center" style="margin-top: 30px;margin-bottom: 0;">iBrand Laravel Sms</h2>';
        $html .= '<p style="margin-bottom: 30px;font-size: 13px;color: #888;" align="center">' . 1.0 . '</p>';
        $html .= '<p><a href="https://github.com/ibrandcc/laravel-sms" target="_blank">ibrand laravel-sms源码</a>托管在GitHub，欢迎你的使用。如有问题和建议，欢迎提供issue。</p>';
        $html .= '<hr>';
        $html .= '<p>你可以在调试模式(设置config/app.php中的debug为true)下查看到存储在存储器中的验证码短信/语音相关数据:</p>';
        echo $html;
        if (config('app.debug')) {
            dump(Sms::getStorage()->get('ibrand.sms.' . request('mobile'),''));
        } else {
            echo '<p align="center" style="color: red;">现在是非调试模式，无法查看调试数据</p>';
        }
    }
}