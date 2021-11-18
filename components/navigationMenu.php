<?php
/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App;
use IvoPetkov\HTML5DOMDocument;

$app = App::get();
$context = $app->contexts->get(__DIR__);

$type = 'horizontal-down';
$temp = (string) $component->type;
if ($temp !== '') {
    if (array_search($temp, ['horizontal-down', 'vertical-left', 'vertical-right', 'list-vertical', 'list-horizontal']) !== false) {
        $type = $temp;
    }
}
$moreItemHtml = '<li><a>...</a><ul></ul></li>';
$temp = (string) $component->moreItemHtml;
if ($temp !== '') {
    $moreItemHtml = $temp;
}

$innerHTML = trim($component->innerHTML);
if (!isset($innerHTML[0])) {
    $innerHTML = '<ul></ul>';
}
$domDocument = new HTML5DOMDocument();
$domDocument->loadHTML($innerHTML, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
$rootElement = $domDocument->querySelector('ul');
if ($rootElement === null) {
    return;
}
$elementID = 'nvgmn' . md5(uniqid());
$rootElement->setAttribute('id', $elementID);
$hasDropMenus = $type === 'horizontal-down' || $type === 'vertical-left' || $type === 'vertical-right';
if ($hasDropMenus) {
    $rootElement->setAttribute('data-nm-type', $type);
}

$dataResponsiveAttributes = $component->getAttribute('data-responsive-attributes');
$hasResponsiveAttributes = strlen($dataResponsiveAttributes) > 0;
if ($hasResponsiveAttributes) {
    $rootElement->setAttribute('data-responsive-attributes', str_replace('=>type=', '=>data-nm-type=', $dataResponsiveAttributes));
}

$classAttribute = (string) $component->class;
if ($classAttribute !== '') {
    $rootElement->setAttribute('class', $classAttribute);
}
$styleAttribute = (string) $component->style;
if ($styleAttribute !== '') {
    $rootElement->setAttribute('style', $styleAttribute);
}
$content = $rootElement->outerHTML;

$style = '';

if ($hasDropMenus) {
    $styleTemplate = '#id[data-nm-type="horizontal-down"]{position:relative;white-space:nowrap;max-width:100%;overflow:hidden;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] li,#id[data-nm-type="horizontal-down"] ul{list-style-type:none;list-style-position:outside;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] > li{display:inline-block;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] li{position:relative;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] ul{position:absolute;top:0;left:0;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] li > ul{display:none;}';
    $styleTemplate .= '#id[data-nm-type="horizontal-down"] li:hover > ul{display:inline-block;}';

    $styleTemplate .= '#id[data-nm-type="vertical-left"]{position:relative;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] li,#id[data-nm-type="vertical-left"] ul{list-style-type:none;list-style-position:outside;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] > li{display:block;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] li{position:relative;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] ul{position:absolute;top:0;left:0;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] li > ul{display:none;}';
    $styleTemplate .= '#id[data-nm-type="vertical-left"] li:hover > ul{display:inline-block;}';

    $styleTemplate .= '#id[data-nm-type="vertical-right"]{position:relative;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] li,#id[data-nm-type="vertical-right"] ul{list-style-type:none;list-style-position:outside;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] > li{display:block;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] li{position:relative;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] ul{position:absolute;top:0;left:0;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] li > ul{display:none;}';
    $styleTemplate .= '#id[data-nm-type="vertical-right"] li:hover > ul{display:inline-block;}';
} else {
    $styleTemplate = '#id,#id ul{list-style-type:none;list-style-position:outside;}';
    $styleTemplate .= '#id li{list-style-type:none;list-style-position:outside;}';
}
$style .= str_replace('#id', '#' . $elementID, $styleTemplate);

$attributes = '';
echo '<html><head>';
if ($hasDropMenus) {
    echo '<link rel="client-packages-embed" name="-ivopetkov-navigation-menu">';
}
if ($hasResponsiveAttributes) {
    echo '<link rel="client-packages-embed" name="responsiveAttributes">';
}
echo '<style>';
echo $style;
echo '</style></head><body>';
echo $content;
if ($hasDropMenus) {
    echo '<script>clientPackages.get(\'-ivopetkov-navigation-menu\').then(function(n){n.make("' . $elementID . '","data-nm-type",' . json_encode($moreItemHtml) . ');});</script>';
    if ($hasResponsiveAttributes) {
        echo '<script>clientPackages.get(\'responsiveAttributes\').then(function(r){r.run();})</script>';
    }
}
echo '</body></html>';
