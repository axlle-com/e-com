<?php

use App\Common\Models\Setting\Setting;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

function _dd_($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function _dd($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function _microtime_to_string(): string
{
    return (new DateTime('NOW'))->format('d-m-Y H:i:s.u');
}

function _view($view = null, $data = [], $mergeData = [])
{
    $template = Setting::template();

    return view($template . $view, $data, $mergeData);
}

function _create_path($path = ''): string
{
    if(defined('ROOT')) {
        $dir = ROOT;
    } else {
        if($_SERVER['DOCUMENT_ROOT']) {
            $dir = $_SERVER['DOCUMENT_ROOT'];
        } else {
            $dir = dirname(__FILE__, 3);
        }
    }
    if(is_writable($dir)) {
        $dir .= '/' . trim($path, ' /');
        if(!file_exists($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }

        return $dir;
    }
    throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
}

function _gitignore($path = '')
{
    if($path) {
        $path = rtrim($path, '/\\');
        $path .= '/.gitignore';
        $text = '*' . PHP_EOL . '!.gitignore' . PHP_EOL;
        file_put_contents($path, $text);
    }
}

function _write_file(string $path = '', string $name = '', $body = []): void
{
    try {
        $path = _create_path('/storage/' . $path);
        $nameW = ($name ?? '') . _unix_to_string_moscow(null, '_d_m_Y_') . '.log';
        $fileW = fopen($path . '/' . $nameW, 'ab');
        fwrite($fileW, '**********************************************************************************' . "\n");
        fwrite($fileW, _unix_to_string_moscow() . ' : ' . json_encode($body, JSON_UNESCAPED_UNICODE) . "\n");
        fclose($fileW);
    } catch(Exception $exception) {
    }
}

function _float_range($first = 0, $second = 1): float|int
{
    if($first >= $second) {
        throw new RuntimeException('Invalid range [ ' . $first . ' >= ' . $second . ' ]');
    }
    $firstArr = explode('.', (string)(float)$first);
    $secondArr = explode('.', (string)(float)$second);
    $firstEnd = $firstArr[1] ?? '';
    $secondEnd = $secondArr[1] ?? '';
    $diff = strlen($firstEnd) - strlen($secondEnd);
    if($diff <= 0) {
        $firstEnd = str_pad($firstEnd, strlen($firstEnd) + $diff, '0');
    } else {
        $secondEnd = str_pad($secondEnd, strlen($secondEnd) + $diff, '0');
    }
    $ran = strlen($firstEnd);
    $numFirst = (int)$firstArr[0] . $firstEnd;
    $numSecond = (int)$secondArr[0] . $secondEnd;
    $int = random_int($numFirst, $numSecond);

    return $int / (10 ** $ran);
}

function _is_associative($array, $allStrings = true): bool
{
    if(!is_array($array) || empty($array)) {
        return false;
    }
    if($allStrings) {
        foreach($array as $key => $value) {
            if(!is_string($key)) {
                return false;
            }
        }

        return true;
    }
    foreach($array as $key => $value) {
        if(is_string($key)) {
            return true;
        }
    }

    return false;
}

function _is_indexed($array, $consecutive = false): bool
{
    if(!is_array($array)) {
        return false;
    }
    if(empty($array)) {
        return true;
    }
    if($consecutive) {
        return array_keys($array) === range(0, count($array) - 1);
    }
    foreach($array as $key => $value) {
        if(!is_int($key)) {
            return false;
        }
    }

    return true;
}

function _set_alias(string $str, array $options = []): string
{
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding($str, 'UTF-8', mb_list_encodings());

    $defaults =
        ['delimiter' => '-', 'limit' => null, 'lowercase' => true, 'replacements' => [], 'transliterate' => true,];

    // Merge options
    $options = array_merge($defaults, $options);

    $char_map = [// Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E',
        'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 'ß' => 'ss', 'à' => 'a', 'á' => 'a', 'â' => 'a',
        'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o',
        'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u',
        'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y',

        // Latin symbols
        '©' => '(c)',

        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8', 'Ι' => 'I',
        'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S',
        'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W', 'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I',
        'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I', 'Ϋ' => 'Y', 'α' => 'a', 'β' => 'b', 'γ' => 'g',
        'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8', 'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm',
        'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p', 'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f',
        'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w', 'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h',
        'ώ' => 'w', 'ς' => 's', 'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G', 'ş' => 's', 'ı' => 'i', 'ç' => 'c',
        'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
        'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
        'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh',
        'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya', 'а' => 'a', 'б' => 'b', 'в' => 'v',
        'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G', 'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u', 'ž' => 'z',

        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z',

        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 'Š' => 'S',
        'Ū' => 'u', 'Ž' => 'Z', 'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l',
        'ņ' => 'n', 'š' => 's', 'ū' => 'u', 'ž' => 'z',];

    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

    // Transliterate characters to ASCII
    if($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ?: mb_strlen($str, 'UTF-8')), 'UTF-8');

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

function _frontend_img(string $name): string
{
    $template = Setting::model()->getTemplate();

    return '/frontend/' . $template . '/assets/img/' . trim($name, '/');
}

function _frontend_js(string $route): string
{
    $s = '';
    $route = trim($route, '/');
    if(config('app.test')) {
        $route = '/frontend/js/_' . $route . '.js';
        $filename = public_path($route);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<script src="' . $route . '?v' . $time . '"></script>';
        }
        $glob = '/main/js/glob.js';
        $filename = public_path($glob);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<script src="' . $glob . '?v' . $time . '"></script>';
        }
        $common = '/frontend/js/common.js';
        $filename = public_path($common);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<script src="' . $common . '?v' . $time . '"></script>';
        }
    } else {
        $route = '/frontend/js/' . $route . '.js';
        $filename = public_path($route);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<script src="' . $route . '?v' . $time . '"></script>';
        }
    }

    return $s;
}

function _frontend_css(string $route): string
{
    $s = '';
    $route = trim($route, '/');
    if(config('app.test')) {
        $route = '/frontend/css/_' . $route . '.css';
        $filename = public_path($route);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<link rel="stylesheet" type="text/css" href="' . $route . '?v' . $time . '">';
        }
        $common = '/frontend/css/common.css';
        $filename = public_path($common);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<link rel="stylesheet" type="text/css" href="' . $common . '?v' . $time . '">';
        }
    } else {
        $route = '/frontend/css/' . $route . '.css';
        $filename = public_path($route);
        if(file_exists($filename)) {
            $time = filemtime($filename);
            $s .= '<link rel="stylesheet" type="text/css" href="' . $route . '?v' . $time . '">';
        }
    }

    return $s;
}

function _active_page(): array
{
    $array = [];
    $url = $_SERVER['REQUEST_URI'];
    if($url === '/admin') {
        $array['admin'] = 'active';
    }
    if(strripos($url, '/admin/blog/category') !== false) {
        $array['blog_category'] = 'active';
    }
    if(strripos($url, '/admin/blog/post') !== false) {
        $array['blog_post'] = 'active';
    }
    if(strripos($url, '/admin/catalog/category') !== false) {
        $array['catalog_category'] = 'active';
    }
    if(strripos($url, 'admin/catalog/product') !== false) {
        $array['catalog_product'] = 'active';
    }
    if(strripos($url, 'admin/catalog/property') !== false) {
        $array['catalog_property'] = 'active';
    }
    if(strripos($url, '/admin/catalog/coupon') !== false) {
        $array['coupon'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document') !== false) {
        $array['document'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/order') !== false) {
        $array['order'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/fin-invoice') !== false) {
        $array['fin_invoice'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/coming') !== false) {
        $array['coming'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/write-off') !== false) {
        $array['write-off'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/reservation') !== false) {
        $array['reservation'] = 'active';
    }
    if(strripos($url, '/admin/catalog/document/reservation-cancel') !== false) {
        $array['reservation-cancel'] = 'active';
    }
    if(strripos($url, '/admin/page') !== false) {
        $array['page'] = 'active';
    }
    if(strripos($url, '/admin/catalog/storage') !== false) {
        $array['catalog_storage'] = 'active';
    }
    if(strripos($url, '/admin/storage-place') !== false) {
        $array['storage_place'] = 'active';
    }
    if(strripos($url, '/admin/report') !== false) {
        $array['report'] = 'active show';
    }
    if(strripos($url, '/admin/report/storage-balance-simple') !== false) {
        $array['storage_balance_simple'] = 'active';
    }

    return $array;
}

function _active_home_page(): array
{
    $array = [];
    $url = $_SERVER['REQUEST_URI'];
    if(strripos($url, '/history') !== false) {
        $array['history'] = 'active';
    }
    if(strripos($url, '/blog') !== false) {
        $array['blog'] = 'active';
    }
    if(strripos($url, '/portfolio') !== false) {
        $array['portfolio'] = 'active';
    }
    if(strripos($url, '/contact') !== false) {
        $array['contact'] = 'active';
    }
    if(strripos($url, '/catalog') !== false) {
        $array['catalog'] = 'active';
    }

    return $array;
}

function _active_front_page(array $menu): string
{
    $url = $_SERVER['REQUEST_URI'] ?? '127.0.0.1';
    $string = '';
    foreach($menu as $item) {
        $class = '';
        $url = str_replace('?' . ($_SERVER['QUERY_STRING'] ?? ''), '', $url);
        $url = trim($url, '/');
        $key = trim($item['href'], '/');
        if($url === $key) {
            $class .= 'active ';
        }
        $class .= 'js-spa-link';
        $class = 'class="' . $class . '"';
        $string .= '<li ' . $class . '><a href="' . $item['href'] . '">' . $item['title'] . '</a></li>';
    }

    return $string;
}

function _uniq_id(): array|string
{
    return mb_strtoupper(str_replace('.', '', uniqid('', true)));
}

function _price($value): string
{
    return number_format($value, 2, '.', ' ') . ' ₽';
}

function _string_price($value): string
{
    $value = explode('.', number_format($value, 2, '.', ''));

    $f = new NumberFormatter('ru', NumberFormatter::SPELLOUT);
    $str = $f->format($value[0]);

    // Первую букву в верхний регистр.
    $str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));

    // Склонение слова "рубль".
    $num = $value[0] % 100;
    if($num > 19) {
        $num %= 10;
    }
    switch($num) {
        case 1:
            $rub = 'рубль';
            break;
        case 2:
        case 3:
        case 4:
            $rub = 'рубля';
            break;
        default:
            $rub = 'рублей';
    }

    return $str . ' ' . $rub . ' ' . $value[1] . ' копеек.';
}

function _clear_price(string $value): string
{
    return preg_replace('/[^.0-9]/', '', $value);
}

function _object_to_array($array): ?array
{
    if(is_object($array) || is_array($array)) {
        $ret = (array)$array;
        foreach($ret as &$item) {
            $item = _object_to_array($item);
        }

        return $ret;
    }

    return $array;
}

function _array_to_string($array): string
{
    $string = '';
    if(is_object($array) || is_array($array)) {
        $ret = (array)$array;
        foreach($ret as &$item) {
            $string .= '|' . _array_to_string($item);
        }

        return trim($string, '| ');
    }
    $string .= $array;

    return trim($string, '| ');
}

function _clear_array($array, bool $tags = true)
{
    if(empty($array)) {
        return $array;
    }
    if(is_array($array) || is_object($array)) {
        $ex = ['description'];
        $newArr = [];
        $array = (array)$array;
        foreach($array as $key => $value) {
            if(is_array($value) || is_object($array)) {
                $newArr[$key] = _clear_array($value);
            } else {
                if(empty($value)) {
                    $newArr[$key] = $value;
                } else {
                    if($tags && !in_array($key, $ex, true)) {
                        $newArr[$key] = _clear_data($value);
                    } else {
                        $newArr[$key] = _clear_soft_data($value);
                    }
                }
            }
        }
    } else {
        return _clear_data($array);
    }

    return $newArr;
}

function _clear_data_search($string): int|string
{
    if(is_numeric($string)) {
        return $string;
    }
    $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $string);
    $string = preg_replace('/ {2,}/', ' ', strip_tags(html_entity_decode($string)));
    $arr = explode(" ", $string);
    $newArr = [];
    foreach($arr as $item) {
        if(mb_strlen($item) > 3) {
            $newArr[] = $item;
        }
    }
    $string = implode(' ', $newArr);
    if(empty($string)) {
        return $string;
    }

    return trim($string);
}

function _clear_data($string): int|string
{
    if(empty($string)) {
        return $string;
    }
    if(is_numeric($string)) {
        return $string;
    }
    $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $string);
    $string = preg_replace('/ {2,}/', ' ', strip_tags(html_entity_decode($string)));

    return trim($string);
}

function _clear_soft_data($string = null): int|string
{
    if(empty($string)) {
        return $string;
    }
    if(is_numeric($string)) {
        return $string;
    }
    $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $string);
    $string = preg_replace('/ {2,}/', ' ', html_entity_decode($string));

    return trim($string);
}

function _domain(): string
{
    $name = $_SERVER['SERVER_NAME'];
    $array = ['https://', 'http://', 'www.',];

    return str_replace($array, '', trim($name, '/'));
}

function _domain_with(string $name): string
{
    $array = ['https://', 'http://', 'www.',];
    $name = preg_replace('#/\)#', ')', $name);

    return str_replace($array, '', preg_replace('#/ #', ' ', $name));
}

function _clear_phone(string|int $phone): string
{
    $phone = preg_replace('/[\D]/', '', $phone);
    if(strlen($phone) !== 10) {
        $phone = substr($phone, -10);
    }

    return $phone;
}

function _pretty_phone(string $phone): string
{
    $phone = preg_replace('[^0-9]', '', $phone);
    if(strlen($phone) !== 10) {
        $phone = substr($phone, 1);
    }
    $sArea = substr($phone, 0, 3);
    $sPrefix = substr($phone, 3, 3);
    $sNumber = substr($phone, 6, 4);

    return '+7(' . $sArea . ')' . $sPrefix . '-' . $sNumber;
}

function _unix_to_string_utc(int $string): string
{
    $unixTime = time();
    $timeZone = new DateTimeZone('UTC');

    $time = new DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    return $time->format('d.m.Y H:i:s');
}

function _string_to_unix_utc(string $string, string $time = '00:00:00'): int
{
    return (new DateTime(trim($string) . ' ' . $time, new DateTimeZone('UTC')))->getTimestamp();
}

function _string_to_unix_moscow(string $string = 'NOW'): int
{
    return (new DateTime(trim($string), new DateTimeZone('Europe/Moscow')))->getTimestamp();
}

function _unix_to_string_moscow(int $string = null, string $format = 'd.m.Y H:i:s'): string
{
    $unixTime = $string ?? time();
    $timeZone = new DateTimeZone('Europe/Moscow');

    $time = new DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    return $time->format($format);
}

function _string_to_unix_utc_period(string $string): array
{
    $dateRange = explode('-', $string);

    return [_string_to_unix_utc($dateRange[0]), _string_to_unix_utc($dateRange[1], '23:59:59'),];
}

function _clear_phone_by_login(?string $phone): ?string
{
    return $phone ? preg_replace('/^\+7/', '', $phone) : null;
}

function _query_string(array $data): string
{
    $string = '';
    foreach($data as $key => $value) {
        if(is_array($value)) {
            foreach($value as $item) {
                $string .= $key . '[]=' . $item . '&';
            }
        } else {
            if(isset($value)) {
                $string .= $key . '=' . $value . '&';
            }
        }
    }

    return trim($string, '&');
}

function _gen_password(int $length = 10): string
{
    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
    $symbols = '?!$#&*(){}[]@+=-_~^%';
    $size = strlen($chars) - 1;
    $sizeSymbols = strlen($symbols) - 1;
    $password = '';
    while($length--) {
        $password .= $chars[random_int(0, $size)];
        $password .= $symbols[random_int(0, $sizeSymbols)];
    }

    return $password;
}

function _string_to_double(string $string): float
{
    return (double)str_replace(',', '.', $string);
}

function _pretty_print($in, $opened = true): string
{
    if($opened) {
        $opened = ' open';
    }
    $string = '';
    if(is_object($in) || is_array($in)) {
        $string .= '<div>';
        $string .= '<div>' . ((is_object($in)) ? 'Object {' : 'Array [') . '</div>';
        $string .= _pretty_print($in, $opened);
        $string .= '<div>' . ((is_object($in)) ? '}' : ']') . '</div>';
        $string .= '</div>';
    }

    return $string;
}

function _pretty_print_rec($in, $opened, $margin = 10): string
{
    if(!is_object($in) && !is_array($in)) {
        return '';
    }
    $inner = '';
    foreach($in as $key => $value) {
        if(is_object($value) || is_array($value)) {
            $inner .= '<div style="margin-left:' . $margin . 'px">';
            $inner .= '<span>' . ((is_object($value)) ? $key . ' {' : $key . ' [') . '</span>';
            $inner .= _pretty_print_rec($value, $opened, $margin + 5);
            $inner .= '<span>' . ((is_object($value)) ? '}' : ']') . '</span>';
            $inner .= '</div>';
        } else {
            $color = '';
            switch(gettype($value)) {
                case 'string':
                    $color = 'red';
                    break;
                case 'integer':
                    $color = 'blue';
                    break;
                case 'double':
                    $color = 'green';
                    break;
            }
            $inner .= '<div style="margin-left:' . $margin . 'px">' . $key . ' : <span style="color:' . $color . '">' .
                $value . '</span></div>';
        }
    }

    return $inner;
}

function _get_response_server(string $url): bool
{
    $header = 0;
    $options = [CURLOPT_URL => $url, CURLOPT_HEADER => true, CURLOPT_NOBODY => true, CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true, CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 5,];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    if(!curl_errno($ch)) {
        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    curl_close($ch);

    return $header === 200;
}

function _get_date(string $date): string
{
    $publisherYear = date('Y', strtotime($date));
    $publisherMonth = date('m', strtotime($date));

    return $date ? _month_array()[$publisherMonth] . ' ' . $publisherYear : '';
}

function _month_array(): array
{
    return ['01' => 'Янв', '02' => 'Фев', '03' => 'Мар', '04' => 'Апр', '05' => 'Май', '06' => 'Июн', '07' => 'Июл',
        '08' => 'Авг', '09' => 'Сен', '10' => 'Окт', '11' => 'Ноя', '12' => 'Дек',];
}

#[Pure(true)]
function _get_full_date(string $date): string
{
    $publisherYear = date('Y', strtotime($date));
    $publisherMonth = date('m', strtotime($date));

    return $date ? _month_full_array()[$publisherMonth] . ' ' . $publisherYear : '';
}

function _month_full_array(): array
{
    return ['01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь',
        '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь',];
}

function _table_list(): array
{
    $array = [];
    foreach(DB::select("SELECT table_name FROM information_schema.tables WHERE table_catalog = 'sanador' AND table_type = 'BASE TABLE' AND table_schema = 'public' ORDER BY table_name;")
            as $tableName) {
        foreach($tableName as $name) {
            $model = _table_name($name);
            if(strripos($model, '_has_')) {
                continue;
            }
            $array[$model] = $model;
        }
    }

    return $array;
}

function _table_name(string $name): string
{
    $array = ['{', '}', '%',];

    return str_replace($array, '', $name);
}

function _substr(string $text, int $end = 300, int $start = 0): string
{
    $text = _clear_data($text);
    $text = substr($text, $start, $end);
    $text = rtrim($text, '!,.-');
    $text = substr($text, 0, strrpos($text, ' '));

    return $text . ' … ';
}
