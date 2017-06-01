<?php
/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use \BearFramework\App;

$app = App::get();
$context = $app->context->get(__FILE__);

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
if (!isset($innerHTML{0})) {
    $innerHTML = '<ul></ul>';
}
$domDocument = new IvoPetkov\HTML5DOMDocument();
$domDocument->loadHTML($innerHTML);
$rootElement = $domDocument->querySelector('ul');
if ($rootElement === null) {
    return;
}
$elementID = 'nvgmn' . md5(uniqid());
$rootElement->setAttribute('id', $elementID);
if ($type === 'horizontal-down' || $type === 'vertical-left' || $type === 'vertical-right') {
    $rootElement->setAttribute('data-nm-type', $type);
    $rootElement->setAttribute('data-nm-more', $moreItemHtml);
}

$dataResponsiveAttributes = $component->getAttribute('data-responsive-attributes');
if (strlen($dataResponsiveAttributes) > 0) {
    $rootElement->setAttribute('data-responsive-attributes', str_replace('=>type=', '=>data-nm-type=', $dataResponsiveAttributes));
}

if ((string) $component->class !== '') {
    $rootElement->setAttribute('class', $component->class);
}
if ((string) $component->style !== '') {
    $rootElement->setAttribute('style', $component->style);
}
$content = $rootElement->outerHTML;

$style = '';

if ($type === 'horizontal-down' || $type === 'vertical-left' || $type === 'vertical-right') {
    $styleTemplate = '#elementid[data-nm-type="horizontal-down"]{position:relative;padding:0;margin:0;}#elementid[data-nm-type="horizontal-down"] li, #elementid[data-nm-type="horizontal-down"] ul{list-style-type:none;list-style-position:outside;}#elementid[data-nm-type="horizontal-down"] > li{display:inline-block;}#elementid[data-nm-type="horizontal-down"] li{position:relative;}#elementid[data-nm-type="horizontal-down"] ul{position:absolute;top:0;left:0;padding:0;margin:0;}#elementid[data-nm-type="horizontal-down"] li > ul{display:none;}#elementid[data-nm-type="horizontal-down"] li:hover > ul{display:inline-block;}#elementid[data-nm-type="vertical-left"]{position:relative;padding:0;margin:0;}#elementid[data-nm-type="vertical-left"] li, #elementid[data-nm-type="vertical-left"] ul{list-style-type:none;list-style-position:outside;}#elementid[data-nm-type="vertical-left"] > li{display:block;}#elementid[data-nm-type="vertical-left"] li{position:relative;}#elementid[data-nm-type="vertical-left"] ul{position:absolute;top:0;left:0;padding:0;margin:0;}#elementid[data-nm-type="vertical-left"] li > ul{display:none;}#elementid[data-nm-type="vertical-left"] li:hover > ul{display:inline-block;}#elementid[data-nm-type="vertical-right"]{position:relative;padding:0;margin:0;}#elementid[data-nm-type="vertical-right"] li, #elementid[data-nm-type="vertical-right"] ul{list-style-type:none;list-style-position:outside;}#elementid[data-nm-type="vertical-right"] > li{display:block;}#elementid[data-nm-type="vertical-right"] li{position:relative;}#elementid[data-nm-type="vertical-right"] ul{position:absolute;top:0;left:0;padding:0;margin:0;}#elementid[data-nm-type="vertical-right"] li > ul{display:none;}#elementid[data-nm-type="vertical-right"] li:hover > ul{display:inline-block;}';
    $style .= str_replace('elementid', $elementID, $styleTemplate);
} else {
    $styleTemplate = '#elementid, #elementid ul{list-style-type:none;list-style-position:outside;padding:0;margin:0;}#elementid li{list-style-type:none;list-style-position:outside;}';
    $style .= str_replace('elementid', $elementID, $styleTemplate);
}

$attributes = '';
?><html>
    <head><?php
        if ($type === 'horizontal-down' || $type === 'vertical-left' || $type === 'vertical-right') {
            echo '<script id="navigation-menu-bearframework-addon-script-1" src="' . $context->assets->getUrl('assets/navigationMenu.min.js', ['cacheMaxAge' => 999999, 'version' => 1]) . '" />';
        }
        echo '<script id="navigation-menu-bearframework-addon-script-2" src="' . $context->assets->getUrl('assets/responsiveAttributes.min.js', ['cacheMaxAge' => 999999, 'version' => 1]) . '" />';
        ?><style><?= $style ?></style>
    </head>
    <body><?php
        echo $content;
        if ($type === 'horizontal-down' || $type === 'vertical-left' || $type === 'vertical-right') {
            echo '<script>ivoPetkov.navigationMenu.initialize(\'' . $elementID . '\',\'data-nm-type\',\'data-nm-more\')</script>';
        }
        ?></body>
</html>