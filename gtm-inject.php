<?php

/**
 * Google Tag Manager Code Snippets Inject
 *
 * A simple WordPress plugin for inject the Google Tag Manager
 * JS code snippet into the site <head> and the noscript snippet
 * after the open <body> tag.
 *
 * In order to put the plugin into action you must first define
 * `GTM_CONTAINER_ID` constant in the `wp-config.php` file and
 * set its value to the unique container ID you got from GTM.
 *
 * phpcs:disable Generic.Files.InlineHTML
 *
 * @wordpres-muplugin
 * Plugin Name:     Google Tag Manager Inject
 * Plugin URI:      https://github.com/valajeb/gtm-inject
 * Description:     A simple WordPress plugin for inject the Google Tag Manager JS code snippet into the site &lt;head&gt; and the noscript snippet after the open &lt;body&gt; tag.
 * Version:         1.0.0
 * Requires PHP:    7.1
 * Author:          Valentin Jebelev
 * Author URI:      https://github.com/valajeb
 * Text Domain:     gtm-inject
 */

namespace Devly\GTMInject;

$n = function ($func_name) {
    return __NAMESPACE__ . '\\' . $func_name;
};

if (empty(container_id())) {
    /**
     * Display admin notice if GTM_CONTAINER_ID not defined
     * and stop execution of the plugin.
     */
    add_action('admin_notices', $n('missing_container_id_notice'));

    return;
}

/**
 * Inject GTM code snippet into the site `<head>`.
 *
 * @return void
 */
function head_snippet(): void
{
    foreach (container_id() as $container_id) {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })( window,document,'script','dataLayer','<?php echo esc_attr($container_id); ?>');</script>
        <!-- End Google Tag Manager -->
        <?php
    }
}

add_action('wp_head', $n('head_snippet'), 0);

/**
 * Inject GTM (noscript) snippet after the open `<body>` tag.
 *
 * @return void
 */
function body_snippet(): void
{
    foreach (container_id() as $container_id) {
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($container_id); ?>"
              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }
}

add_action('wp_body_open', $n('body_snippet'), 0);

function missing_container_id_notice(): void
{
    $class   = 'notice notice-error';
    $message = __('<b>Inject GTM Code Plugin Error:</b> In order to put the 
    plugin into action you must first define <code>GTM_CONTAINER_ID</code> constant 
    in the <b>wp-config.php</b> file and set it\'s value to the unique container 
    ID you got from GTM.', 'gtm-inject');

    echo '<div class="' . esc_attr($class) . '"><p>';

    echo wp_kses(
        $message,
        [
            'b' => [],
            'strong' => [],
            'u' => [],
            'span' => [
                'class' => [],
            ],
        ]
    );

    echo '</p></div>';
}

function container_id(): array
{
    if (! defined('GTM_CONTAINER_ID')) {
        return [];
    }

    return is_array(GTM_CONTAINER_ID) ? GTM_CONTAINER_ID : [GTM_CONTAINER_ID];
}
