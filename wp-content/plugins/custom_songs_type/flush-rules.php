<?php
// Force flush rewrite rules
define('WP_USE_THEMES', false);
require_once('/var/www/html/wp-blog-header.php');

global $wp_rewrite;
$wp_rewrite->flush_rules(true);

echo "Rewrite rules flushed with hard flush\n";

// Check if rules are now saved
$rules = get_option('rewrite_rules');
if (is_array($rules)) {
    echo "Rules count: " . count($rules) . "\n";
    foreach ($rules as $pattern => $replacement) {
        if (strpos($pattern, 'song') !== false) {
            echo "Song pattern: $pattern -> $replacement\n";
        }
    }
} else {
    echo "Still no rewrite rules found\n";
} 