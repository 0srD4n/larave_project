<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class captcha extends Controller
{
    public function generate()
    {
        $captchaText = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 6);

        Session::put('captcha_text', $captchaText);

        $image = imagecreate(100, 40);
        $backgroundColor = imagecolorallocate($image, 0, 0, 0);
        // simple aja dulu
        $textColor = imagecolorallocate($image, 255, 255, 255);

        imagestring($image, 5, 10, 10, $captchaText, $textColor);

        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}