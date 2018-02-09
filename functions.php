<?php

function centerrow_display_featured_exhibit()
{
    $html = '';
    $featuredExhibit = exhibit_builder_random_featured_exhibit();
    if ($featuredExhibit) {
        $html .= get_view()->partial('exhibit-builder/exhibits/single.php', array('exhibit' => $featuredExhibit));
    }
    $html = apply_filters('exhibit_builder_display_random_featured_exhibit', $html);
    return $html;
}

function bc_label_table_options($options, $default = null)
{
    $option_list = label_table_options($options, $default);
    unset($option_list['']);
    return $option_list;
}

function bc_filter_select_options($input, $whitelist)
{
    return array_filter(
        $input,
        function ($value) use ($whitelist) {
            return in_array(rtrim($value), $whitelist, true);
        }
    );
}

function bc_rename_select_options($input)
{
    $rename_map = [
        'Creator'     => 'Artist',
        'Has Part'    => 'Transcription',
        'Description' => 'Condition',
        'Coverage'    => 'Place',
        'Extent'      => 'Dimensions',
        'Type'        => 'Genre'
    ];

    $keys = array_keys($input);

    foreach ($keys as $key) {
        $value = $input[$key];
        $input[$key] = isset($rename_map[$value]) ? $rename_map[$value] : $value;
    }

    return $input;
}