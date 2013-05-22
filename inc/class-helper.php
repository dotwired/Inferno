<?php

/**
 * Generous library for common functions Inferno may need.
 */
class Inferno_Helper {

    /**
     * function to trim the values of an array recursively
     * @param  array $array array to trim
     * @return array        the trimmed array
     */
    public static function trim_r($array) {
        if (is_string($array)) {
            return trim($array);
        } else if (!is_array($array)) {
            return '';
        }
        $keys = array_keys($array);
        for ($i=0; $i<count($keys); $i++) {
            $key = $keys[$i];
            if ( is_array($array[$key]) ) {
                $array[$key] = Inferno_Helper::trim_r($array[$key]);
            } else if ( is_string($array[$key]) ) {
                $array[$key] = trim($array[$key]);
            }
        }
        return $array;
    }

    /**
     * function to strip slashes the values of an array recursively
     * @param  array $array array to strip slashes
     * @return array        the stripslashed array
     */
    public static function stripslashes_r($array) {
        if (is_string($array)) {
            return stripslashes($array);
        } else if (!is_array($array)) {
            return '';
        }
        $keys = array_keys($array);
        for ($i=0; $i<count($keys); $i++) {
            $key = $keys[$i];
            if ( is_array($array[$key]) ) {
                $array[$key] = Inferno_Helper::stripslashes_r($array[$key]);
            } else if ( is_string($array[$key]) ) {
                $array[$key] = stripslashes($array[$key]);
            }
        }
        return $array;
    }


    /**
     * function to encode html special chars in values of an array recursively
     * @param  array $array array to encode
     * @return array        the encoded array
     */
    public static function htmlspecialchars_r($array) {
        if (is_string($array)) {
            return htmlspecialchars($array);
        } else if (!is_array($array)) {
            return '';
        }
        $keys = array_keys($array);
        for ($i=0; $i<count($keys); $i++) {
            $key = $keys[$i];
            if ( is_array($array[$key]) ) {
                $array[$key] = Inferno_Helper::htmlspecialchars_r($array[$key]);
            } else if ( is_string($array[$key]) ) {
                $array[$key] = htmlspecialchars($array[$key]);
            }
        }
        return $array;
    }

    /**
     * function to decode html special chars in values of an array recursively
     * @param  array $array array to decode
     * @return array        the decoded array
     */
    public static function htmlspecialchars_decode_r($array) {
        if (is_string($array)) {
          return htmlspecialchars_decode($array);
      } else if (!is_array($array)) {
          return '';
      }
      $keys = array_keys($array);
      for ($i=0; $i<count($keys); $i++) {
          $key = $keys[$i];
          if ( is_array($array[$key]) ) {
              $array[$key] = Inferno_Helper::htmlspecialchars_decode_r($array[$key]);
          } else if ( is_string($array[$key]) ) {
              $array[$key] = htmlspecialchars_decode($array[$key]);
          }
      }
      return $array;
    }

    /**
     * function to recurively look if an array is empty or not
     * @param  mixed $mixed commonly an array
     * @return bool true|false
     */
    public static function array_empty($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $value) {
                if (!Inferno_Helper::array_empty($value)) {
                    return false;
                }
            }
        }
        elseif (!empty($mixed)) {
            return false;
        }
        return true;
    }

    public static function get_video_embed_url($video_url = '')
    {
        // if youtube
        if(strpos($video_url, 'http://www.youtube.com/') === 0) {
            $query_string = array();
            parse_str(parse_url($video_url, PHP_URL_QUERY), $query_string);
            $id = $query_string["v"];
            $embed_url = 'http://www.youtube.com/embed/' . $id . '?rel=0&amp;wmode=transparent';
        }
        elseif(strpos($video_url, 'https://vimeo.com/') === 0) {
            $id = (int)substr(parse_url($video_url, PHP_URL_PATH), 1);
            $embed_url = 'http://player.vimeo.com/video/' . $id;
        }

        return $embed_url;
    }

    public static function sanitize_data($data, $type) 
    {
        if(!empty($data) || $data !== '') {
            switch ($type) {
                case 'range':
                    return intval($data);
                    break;
                default: // for 'text', 'colorpicker', 'color', 'radio', 'select', 'font', 'file', 'textarea' and any unexpected type
                    return sanitize_text_field($data);
                    break;
            }
        }

        return null;
    }
}