<?php

namespace WebWork\Features;

class Validation {
    private static $passes = true;
    private static $requestData = [];

    public static function rules(array $data) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $k => $v) {
                self::$requestData[$k] = $v;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            foreach ($_GET as $k => $v) {
                self::$requestData[$k] = $v;
            }
        }

        foreach ($data as $key => $value) {
            $rules = explode('|', $value);

            foreach ($rules as $rule) {
                switch ($rule) {
                    case 'text':
                        if (isset($_FILES[$key])) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Invalid text']);

                            break 2;
                        }

                        break;

                    case 'required':
                        if (!isset(self::$requestData[$key]) || self::$requestData[$key] === null || self::$requestData[$key] === '') {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'The field "'.$key.'" is required']);

                            break 2;
                        }

                        break;

                    case 'email':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_EMAIL)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Invalid email']);

                            break 2;
                        }

                        break;

                    case 'file':
                        if (!isset($_FILES[$key]) || !is_file($_FILES[$key])) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field "'.$key.'" must be a file']);

                            break 2;
                        }

                        break;

                    case 'number':
                        if (!is_numeric(self::$requestData[$key])) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field "'.$key.'" mus be a valid number']);

                            break 2;
                        }

                        break;

                    case 'alphanumeric':
                        if (!ctype_alnum(self::$requestData[$key])) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field "'.$key.'" must consist of alphanumeric characters']);

                            break 2;
                        }

                        break;

                    case 'int':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_INT)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field '.$key.' must be an integer']);

                            break 2;
                        }

                        break;

                    case 'float':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_FLOAT)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field '.$key.' must be a float number']);

                            break 2;
                        }

                        break;

                    case 'bool':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_BOOLEAN)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field '.$key.' must be boolean']);

                            break 2;
                        }

                        break;

                    case 'domain':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_DOMAIN)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field '.$key.' must be a valid domain']);

                            break 2;
                        }

                        break;

                    case 'ip':
                        if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_IP)) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field '.$key.' must be a valid IP address']);

                            break 2;
                        }

                        break;

                        case 'url':
                            if (!filter_var(self::$requestData[$key], FILTER_VALIDATE_URL)) {
                                self::$passes = false;
    
                                redirectBack(['validation_error' => 'Field '.$key.' must be a valid URL']);
    
                                break 2;
                            }
    
                            break;

                        case 'recaptcha':
                            if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
                                self::$passes = false;
    
                                redirectBack(['validation_error' => 'Recaptcha check failed']);
    
                                break 2;
                            }
    
                            break;
                }

                // Regex checking for arguments list (e.g. min:value)
                switch (true) {
                    case preg_match('/min:([a-z])/i', $rule, $matches):
                        if ((float)$value < (float)$matches[1]) {
                            self::$passes = false;

                            redirectBack(['validation_error' => 'Field "'.$key.'" must be greater than '.$matches[1]]);

                            break 2;
                        }

                        break;
                }
            }
        }
    }
}
