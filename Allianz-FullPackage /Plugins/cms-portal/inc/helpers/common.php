<?php
if (!function_exists('cpt_generate_protected_code')) {
    function cpt_generate_protected_code($length = 11)
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true) . ':' . microtime(true)), 5, $length));
    }
}

if (!function_exists('cpt_generate_slug')) {
    function cpt_generate_slug($str, $delimiter = '-')
    {
        $str = trim($str);
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}

if (!function_exists('cpt_get_server_url')) {
    function cpt_get_server_url()
    {
        $theme = wp_get_theme();
        $author = strtolower($theme->get('Author'));
        $server_url = '';
        switch ($author) {
            case 'cmssuperheroes':
                $server_url = CPT_SERVER_URL;
                break;
            case 'farost':
                $server_url = CPT_FAROST_SERVER_URL;
                break;
            case '7oroof':
                $server_url = CPT_7OROOF_SERVER_URL;
                break;
            default:
                $server_url = CPT_SERVER_URL;
        }

        return $server_url;
    }
}

if (!function_exists('cpt_svg_e')) {
    function cpt_svg_e($file_name)
    {
        include CPT_PATH . '/assets/images/svgs/' . $file_name . '.svg';
    }
}

if (!function_exists('cpt_svg__')) {
    function cpt_svg__($file_name)
    {
        ob_start();
        include CPT_PATH . '/assets/images/svgs/' . $file_name . '.svg';
        return ob_get_clean();
    }
}

if (!function_exists('cpt_server_requestable')) {
    function cpt_server_requestable()
    {
        $dev_mode = apply_filters('cpt_dev_mode', false);
        if ($dev_mode == true) {
            return 1;
        }
        $server_requestable = get_transient(CPT_SERVER_REQUESTABLE);
        return false !== $server_requestable && $server_requestable == 1 ? 1 : -1;
    }
}

if (!function_exists('cpt_get_host')) {
    function cpt_get_host()
    {
        $urlparts = wp_parse_url(home_url());
        if (!is_array($urlparts) || !isset($urlparts['host'])) {
            return '';
        }

        return $urlparts['host'];
    }
}

if (!function_exists('cpt_is_same_domain')) {
    function cpt_is_same_domain($url1, $url2)
    {
        $host1 = parse_url($url1, PHP_URL_HOST);
        $host2 = parse_url($url2, PHP_URL_HOST);

        // Normalize by removing "www." if needed
        $host1 = preg_replace('/^www\./', '', strtolower($host1));
        $host2 = preg_replace('/^www\./', '', strtolower($host2));

        return $host1 === $host2;
    }
}
?>