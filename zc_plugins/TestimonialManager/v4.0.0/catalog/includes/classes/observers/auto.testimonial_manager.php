<?php
/**
 * Part of the Testimonials Manager, v4.0.0 and later.
 *
 * Last updated: v4.0.0 (new)
 *
 * For Zen Cart versions prior to v3.0.0, requires changes associated with these
 * Zen Cart PRs:
 *
 * - https://github.com/zencart/zencart/pull/7703 (adds NOTIFY_NONCAPTCHA_OBSERVER_FIELD_CHECK)
 */

class zcObserverTestimonialManager extends base
{
    public function __construct()
    {
        $this->attach($this, [
            'NOTIFY_NONCAPTCHA_OBSERVER_FIELD_CHECK',
            'NOTIFY_MODULE_META_TAGS_UNSPECIFIEDPAGE',
            'NOTIFY_INFORMATION_SIDEBOX_ADDITIONS',
        ]);
    }

    public function updateNotifyNoncaptchaObserverFieldCheck(&$class, string $e, array $current_fields, array &$updated_fields): void
    {
        $tm_fields = [
            'testimonials_name', // comment-out if you actually want to allow URLs for this
            'testimonials_title', // comment-out if you actually want to allow URLs for this
            'testimonials_html_text', // comment-out if you actually want to allow URLs for this
        ];
        $updated_fields = array_merge($current_fields, $tm_fields);
    }
    
    public function updateNotifyModuleMetaTagsUnspecifiedpage(&$class, string $e, string $current_page_base): void
    {
        if ($current_page_base === FILENAME_TESTIMONIALS_MANAGER) {
            global $page_check; //- Set by the page's header_php.php
            $testimonials_title = zen_output_string_protected($page_check->fields['testimonials_title']);

            zen_define_default('META_TAG_TITLE', META_TAG_TITLE_PAGE_TESTIMONIALS_MANAGER . $testimonials_title);
            zen_define_default('META_TAG_DESCRIPTION', META_TAG_TITLE_PAGE_TESTIMONIALS_MANAGER . zen_trunc_string($page_check->fields['testimonials_html_text'], TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH));
            zen_define_default('META_TAG_KEYWORDS', META_TAG_TITLE_PAGE_TESTIMONIALS_MANAGER . $testimonials_title);
        } elseif ($current_page_base === FILENAME_TESTIMONIALS_MANAGER_ALL) {
            zen_define_default('META_TAG_TITLE', META_TAG_TITLE_PAGE_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS);
        }
    }

    public function updateNotifyInformationSideboxAdditions(&$class, string $e, mixed $unused, array &$information): void
    {
        if (DEFINE_TESTIMONIAL_STATUS <= 1) {
            // -----
            // Bootstrap template integration, use defined classes, if set.
            //
            global $information_classes;
            $link_class = isset($information_classes) ? 'class="' . $information_classes . '"' : '';

            $information[] = '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL) . '" ' . $link_class . '>' . BOX_HEADING_TESTIMONIALS_MANAGER . '</a>';
        }
    }
}
