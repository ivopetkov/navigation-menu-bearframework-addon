<?php

/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use \BearFramework\App;

$app = App::get();
$context = $app->contexts->get(__DIR__);


$app->clientPackages
    ->add('-ivopetkov-navigation-menu', function (IvoPetkov\BearFrameworkAddons\ClientPackage $package) use ($context) {
        //$package->addJSCode(file_get_contents($context->dir . '/dev/navigationMenu.js'));
        $package->addJSCode(include $context->dir . '/assets/navigationMenu.min.js.php');
        $package->get = 'return ivoPetkov.bearFrameworkAddons.navigationMenu;';
    })
    ->add('-ivopetkov-navigation-menu-responsive-attributes', function (IvoPetkov\BearFrameworkAddons\ClientPackage $package) {
        // taken from dev/responsiveAttributes.min.js
        $code = 'responsiveAttributes=function(){var v=[],w=!1,g=function(){if(!w){w=!0;for(var g=document.querySelectorAll("[data-responsive-attributes]"),u=g.length,x=0;x<u;x++){var h=g[x],r=h.getBoundingClientRect();r={width:r.width,height:r.height};var f=h.getAttribute("data-responsive-attributes");if("undefined"===typeof v[f]){for(var b=f.split(","),m=b.length,k=[],e=0;e<m;e++){var c=b[e].split("=>");if("undefined"!==typeof c[0]&&"undefined"!==typeof c[1]){var n=c[0].trim();if(0<n.length){var a=c[1].split("=");"undefined"!==typeof a[0]&&"undefined"!==typeof a[1]&&(c=a[0].trim(),0<c.length&&(a=a[1].trim(),0<a.length&&("undefined"===typeof k[c]&&(k[c]=[]),k[c].push([n,a]))))}}}v[f]=k}f=v[f];for(var t in f){b=h.getAttribute(t);null===b&&(b="");b=0<b.length?b.split(" "):[];m=f[t];k=m.length;for(e=0;e<k;e++){n=m[e][1];c=h;a=m[e][0];for(var p=r,d=[],l=0;100>l;l++){var q="f"+d.length,y=a.match(/f\((.*?)\)/);if(null===y)break;a=a.replace(y[0],q);d.push([q,y[1]])}a=a.split("vw").join(window.innerWidth).split("w").join(p.width).split("vh").join(window.innerHeight).split("h").join(p.height);for(l=d.length-1;0<=l;l--)q=d[l],a=a.replace(q[0],q[1]+"(element,details)");c=(new Function("element","details","return "+a))(c,p);a=!1;p=b.length;for(d=0;d<p;d++)if(b[d]===n){c?a=!0:b.splice(d,1);break}c&&!a&&b.push(n)}b=b.join(" ");h.getAttribute(t)!==b&&h.setAttribute(t,b)}}w=!1}},u=function(){window.addEventListener("resize",g);window.addEventListener("load",g);"undefined"!==typeof MutationObserver&&(new MutationObserver(function(){g()})).observe(document.querySelector("body"),{childList:!0,subtree:!0})};"loading"===document.readyState?document.addEventListener("DOMContentLoaded",u):u();return{run:g}}();';
        $package->addJSCode($code);
        $package->get = 'return responsiveAttributes;';
    });

$app->components
    ->addAlias('navigation-menu', 'file:' . $context->dir . '/components/navigationMenu.php');
