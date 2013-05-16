<?php


/**
 * Perform the saving from the received panel data.
 * @version 1.0
 * @since 1.0
 */
function script_data() {
    wp_localize_script( $handle, $object_name, $l10n );
}



function has_my_shortcode($posts) {
    if(empty($posts))
        return $posts;

    $found = false;

    foreach ($posts as $post) {
        if(stripos($post->post_content, '[my_shortcode'))
            $found = true;
            break;
        }

    if ($found){
        $urljs = get_template_directory_uri() .IMP_JS;

    wp_register_script('my_script', $urljs.'myscript.js' );

    wp_print_scripts('my_script');
}
    return $posts;
}
add_action('the_posts', 'has_my_shortcode');