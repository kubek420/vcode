<?php

function captchaKey() {
    if (!config('RECAPTCHA_KEY')) {
        error('Provide your Captcha sitekey in config.json');
    }

    return config('RECAPTCHA_KEY');
}
