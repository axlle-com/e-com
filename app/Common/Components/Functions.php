<?php

function ax_dd($data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function ax_is_associative($array, $allStrings = true): bool
{
    if (!is_array($array) || empty($array)) {
        return false;
    }
    if ($allStrings) {
        foreach ($array as $key => $value) {
            if (!is_string($key)) {
                return false;
            }
        }
        return true;
    }
    foreach ($array as $key => $value) {
        if (is_string($key)) {
            return true;
        }
    }
    return false;
}

function ax_is_indexed($array, $consecutive = false): bool
{
    if (!is_array($array)) {
        return false;
    }
    if (empty($array)) {
        return true;
    }
    if ($consecutive) {
        return array_keys($array) === range(0, count($array) - 1);
    }
    foreach ($array as $key => $value) {
        if (!is_int($key)) {
            return false;
        }
    }
    return true;
}

function ax_set_alias(string $str, array $options = []): string
{
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

    $defaults = [
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => [],
        'transliterate' => true,
    ];

    // Merge options
    $options = array_merge($defaults, $options);

    $char_map = [
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',

        // Latin symbols
        '©' => '(c)',

        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',

        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',

        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',

        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    ];

    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}


function ax_assets(string $url): string
{
    return '/' . ltrim($url, '/\\');
}

function ax_frontend(string $url): string
{
    return public_path('/frontend/' . trim($url, '/\\'));
}

function ax_backend(string $url): string
{
    return public_path('/backend/' . trim($url, '/\\'));
}

function ax_active_page(): array
{
    $array = [];
    $url = $_SERVER['REQUEST_URI'];
    if ($url === '/admin') {
        $array['admin'] = 'active';
    }
    if (strripos($url, '/admin/blog/category') !== false) {
        $array['blog_category'] = 'active';
    }
    if (strripos($url, '/admin/blog/post') !== false) {
        $array['blog_post'] = 'active';
    }
    if (strripos($url, '/admin/catalog/category') !== false) {
        $array['catalog_category'] = 'active';
    }
    if (strripos($url, 'admin/catalog/product') !== false) {
        $array['catalog_product'] = 'active';
    }
    if (strripos($url, '/admin/employee') !== false) {
        $array['employee'] = 'active';
    }
    if (strripos($url, '/admin/catalog') !== false) {
        $array['catalog'] = 'active';
    }
    if (strripos($url, '/admin/storage-place') !== false) {
        $array['storage_place'] = 'active';
    }
    if (strripos($url, '/admin/report') !== false) {
        $array['report'] = 'active show';
    }
    if (strripos($url, '/admin/report/storage-balance-simple') !== false) {
        $array['storage_balance_simple'] = 'active';
    }
    return $array;
}

function ax_uniq_id(): array|string
{
    return str_replace('.', '-', uniqid('', true));
}

function ax_string_price($value): string
{
    $value = explode('.', number_format($value, 2, '.', ''));

    $f = new NumberFormatter('ru', NumberFormatter::SPELLOUT);
    $str = $f->format($value[0]);

    // Первую букву в верхний регистр.
    $str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));

    // Склонение слова "рубль".
    $num = $value[0] % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
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

function ax_clear_price(string $value): string
{
    return preg_replace('/[^.0-9]/', '', $value);
}

function ax_object_to_array($array): ?array
{
    if (is_object($array) || is_array($array)) {
        $ret = (array)$array;
        foreach ($ret as &$item) {
            $item = ax_object_to_array($item);
        }
        return $ret;
    }
    return $array;
}

function ax_clear_array(array $array): array
{
    $newArr = [];
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $newArr[$key] = ax_clear_array($value);
            } else {
                $newArr[$key] = $value ? ax_clear_data($value) : $value;
            }
        }
    }
    return $newArr;
}

function ax_clear_data($string): int|string
{
    if (is_numeric($string)) {
        return $string;
    }
    $string = preg_replace('/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u', ' ', $string);
    $string = preg_replace('/ {2,}/', ' ', strip_tags(html_entity_decode($string)));
    return trim($string);
}

function domain(string $name): string
{
    $array = ['https://', 'http://', 'www.'];
    return str_replace($array, '', preg_replace('#/$#', '', $name));
}

function domain_with(string $name): string
{
    $array = ['https://', 'http://', 'www.'];
    $name = preg_replace('#/\)#', ')', $name);
    return str_replace($array, '', preg_replace('#/ #', ' ', $name));
}


function ax_clear_phone(string $phone): string
{
    return preg_replace('/[\D]/', '', $phone);
}

function ax_pretty_phone(string $phone): string
{
    $phone = preg_replace('[^0-9]', '', $phone);
    if (strlen($phone) !== 10) {
        $phone = substr($phone, 1);
    }
    $sArea = substr($phone, 0, 3);
    $sPrefix = substr($phone, 3, 3);
    $sNumber = substr($phone, 6, 4);
    return '+7(' . $sArea . ')' . $sPrefix . '-' . $sNumber;
}

function ax_unix_to_string_utc(int $string): string
{
    $unixTime = time();
    $timeZone = new DateTimeZone('UTC');

    $time = new DateTime();
    $time->setTimestamp($unixTime)->setTimezone($timeZone);

    return $time->format('d.m.Y H:i:s');
}

function ax_string_to_unix_utc(string $string, string $time = '00:00:00'): int
{
    return (new DateTime(trim($string) . ' ' . $time, new DateTimeZone('UTC')))->getTimestamp();
}

function ax_string_to_unix_moscow(string $string = 'NOW'): int
{
    return (new DateTime(trim($string), new DateTimeZone('Europe/Moscow')))->getTimestamp();
}

function axStringToUnixUTCPeriod(string $string): array
{
    $dateRange = explode('-', $string);
    return [ax_string_to_unix_utc($dateRange[0]), ax_string_to_unix_utc($dateRange[1], '23:59:59')];
}

function ax_clear_phone_by_login(?string $phone): ?string
{
    return $phone ? preg_replace('/^\+7/', '', $phone) : null;
}

function ax_query_string(array $data): string
{
    $string = '';
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                $string .= $key . '[]=' . $item . '&';
            }
        } elseif (isset($value)) {
            $string .= $key . '=' . $value . '&';
        }
    }
    return substr($string, 0, -1);
}

function ax_gen_password(int $length = 6): string
{
    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
    $symbols = '?!$#&*(){}[]@+=-_~^%';
    $size = strlen($chars) - 1;
    $sizeSymbols = strlen($symbols) - 1;
    $password = '';
    while ($length--) {
        $password .= $chars[random_int(0, $size)];
        $password .= $symbols[random_int(0, $sizeSymbols)];
    }
    return $password;
}

function ax_string_to_double(string $string): float
{
    return (double)str_replace(',', '.', $string);
}

function ax_pretty_print($in, $opened = true): string
{
    if ($opened) {
        $opened = ' open';
    }
    $string = '';
    if (is_object($in) || is_array($in)) {
        $string .= '<div>';
        $string .= '<div>' . ((is_object($in)) ? 'Object {' : 'Array [') . '</div>';
        $string .= ax_pretty_print($in, $opened);
        $string .= '<div>' . ((is_object($in)) ? '}' : ']') . '</div>';
        $string .= '</div>';
    }
    return $string;

}

function ax_pretty_print_rec($in, $opened, $margin = 10): string
{
    if (!is_object($in) && !is_array($in)) {
        return '';
    }
    $inner = '';
    foreach ($in as $key => $value) {
        if (is_object($value) || is_array($value)) {
            $inner .= '<div style="margin-left:' . $margin . 'px">';
            $inner .= '<span>' . ((is_object($value)) ? $key . ' {' : $key . ' [') . '</span>';
            $inner .= ax_pretty_print_rec($value, $opened, $margin + 5);
            $inner .= '<span>' . ((is_object($value)) ? '}' : ']') . '</span>';
            $inner .= '</div>';
        } else {
            $color = '';
            switch (gettype($value)) {
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
            $inner .= '<div style="margin-left:' . $margin . 'px">' . $key . ' : <span style="color:' . $color . '">' . $value . '</span></div>';
        }
    }
    return $inner;
}

function ax_get_response_server(string $url): bool
{
    $header = 0;
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 5,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    if (!curl_errno($ch)) {
        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    curl_close($ch);
    return $header === 200;
}

function ax_get_date(string $date): string
{
    $publisherYear = date('Y', strtotime($date));
    $publisherMonth = date('m', strtotime($date));
    return $date ? ax_month_array()[$publisherMonth] . ' ' . $publisherYear : '';
}

function ax_month_array(): array
{
    return [
        '01' => 'Янв',
        '02' => 'Фев',
        '03' => 'Мар',
        '04' => 'Апр',
        '05' => 'Май',
        '06' => 'Июн',
        '07' => 'Июл',
        '08' => 'Авг',
        '09' => 'Сен',
        '10' => 'Окт',
        '11' => 'Ноя',
        '12' => 'Дек',
    ];

}

function ax_get_full_date(string $date): string
{
    $publisherYear = date('Y', strtotime($date));
    $publisherMonth = date('m', strtotime($date));
    return $date ? ax_month_full_array()[$publisherMonth] . ' ' . $publisherYear : '';
}

function ax_month_full_array(): array
{
    return [
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь',
    ];
}

function ax_table_list(): array
{
    $array = [];
    foreach (DB::select("SELECT table_name FROM information_schema.tables WHERE table_catalog = 'sanador' AND table_type = 'BASE TABLE' AND table_schema = 'public' ORDER BY table_name;") as $tableName) {
        foreach ($tableName as $name) {
            $model = ax_table_name($name);
            if (strripos($model, '_has_')) {
                continue;
            }
            $array[$model] = $model;
        }
    }
    return $array;
}

function ax_table_name(string $name): string
{
    $array = ['{', '}', '%'];
    return str_replace($array, '', $name);
}

function ax_substr(string $text, int $end = 300, int $start = 0): string
{
    $text = ax_clear_data($text);
    $text = substr($text, $start, $end);
    $text = rtrim($text, '!,.-');
    $text = substr($text, 0, strrpos($text, ' '));
    return $text . ' … ';
}
