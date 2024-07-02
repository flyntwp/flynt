<?php

namespace Flynt\TheContentFix;

use Timber\Timber;

add_filter('wp_insert_post_data', function (array $data, array $postArr): array {
    $excludedPostTypes = [
        'attachment',
        'revision',
        'custom_css',
        'customize_changeset',
        'acf-taxonomy',
        'acf-post-type',
        'acf-ui-options-page',
        'acf-field-group',
        'acf-field'
    ];

    if (in_array($postArr['post_type'], $excludedPostTypes)) {
        return $data;
    }

    $doesPostTypeSupportEditor = isset($data['post_type']) && post_type_supports($data['post_type'], 'editor');
    if ($doesPostTypeSupportEditor) {
        return $data;
    }

    $postContent = (string) $data['post_content'] ?? '';
    $postId =  (int) $postArr['ID'] ?? 0;
    $shouldAddShortcode = $postContent === '' || !doesShortcodeMatchPostId($postContent, $postId);

    if ($shouldAddShortcode) {
        $data['post_content'] = "[flyntTheContent id=\"{$postId}\"]";
    }

    return $data;
}, 99, 2);

add_shortcode('flyntTheContent', function (array $attrs = []) {
    if (is_admin() || empty($attrs['id'])) {
        return '';
    }

    $postId = $attrs['id'];
    $context = Timber::context();
    $context['post'] = Timber::get_Post($postId);
    $context['post']->setup();
    return Timber::compile('templates/theContentFix.twig', $context);
});

function doesShortcodeMatchPostId(string $postContent, int $postId): bool
{
    preg_match('/^\[flyntTheContent id=\\\"(\d*)\\\"\]$/', $postContent, $matches);

    if (!isset($matches) || empty($matches)) {
        return false;
    }

    return $matches[1] === $postId;
}
