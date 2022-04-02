<?php
function ax_dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
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
    if (strripos($url, '/admin/producer') !== false) {
        $array['producer'] = 'active';
    }
    if (strripos($url, '/admin/customer') !== false) {
        $array['customer'] = 'active';
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
