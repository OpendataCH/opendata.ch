<?php



/**
 *  Get template without Params
 */
function get_template_param($template_param)
{
    if (isset($GLOBALS['my_template_params'][$template_param])) {
        return $GLOBALS['my_template_params'][$template_param];
    }

    return false;
}




/**
 *  Get template with Params
 */
function get_template_part_with_params($slug, $name, $params)
{
    $templates = array();
    $name      = (string) $name;

    if ('' !== $name) {
        $templates[] = "{$slug}-{$name}.php";
    }

    $templates[] = "{$slug}.php";

    // Save params to globals
    $GLOBALS['my_template_params'] = $params;

    locate_template($templates, true, false);

    // Empty params to prevent some possible bugs
    $GLOBALS['my_template_params'] = [];
}


function ea_icon($atts = array())
{

    $atts = shortcode_atts(array(
        'icon'    => false,
        'group'    => 'utility',
        'size'    => 16,
        'class'    => false,
    ), $atts);

    if (empty($atts['icon']))
        return;

    $icon_path = get_stylesheet_directory() . '/assets/icons/' . $atts['group'] . '/' . $atts['icon'] . '.svg';
    if (!file_exists($icon_path))
        return;

    $icon = file_get_contents($icon_path);

    $class = 'svg-icon';
    if (!empty($atts['class']))
        $class .= ' ' . esc_attr($atts['class']);

    $repl = sprintf('<svg class="' . $class . '" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $atts['size'], $atts['size']);
    $svg  = preg_replace('/^<svg /', $repl, trim($icon)); // Add extra attributes to SVG code.
    $svg  = preg_replace("/([\n\t]+)/", ' ', $svg); // Remove newlines & tabs.
    $svg  = preg_replace('/>\s*</', '><', $svg); // Remove white space between SVG tags.

    return $svg;
}
