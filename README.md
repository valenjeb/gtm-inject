# WP Google Tag Manager Inject 

A simple WordPress plugin for inject the Google Tag Manager JS code snippet into the site &lt;head&gt; and the &lt;noscript&gt; snippet after the open &lt;body&gt; tag.

## Usage

In order to put the plugin into action you must first define GTM_CONTAINER_ID const in the wp-config.php file and set its value to the container ID you got from GTM.

```php
define( 'GTM_CONTAINER_ID', 'container-id' );
```
