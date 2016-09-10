# Navigation Menu
Addon for Bear Framework

This addon enables you to easily create multiple types of navigations for your website.

[![Build Status](https://travis-ci.org/ivopetkov/navigation-menu-bearframework-addon.svg)](https://travis-ci.org/ivopetkov/navigation-menu-bearframework-addon)
[![Latest Stable Version](https://poser.pugx.org/ivopetkov/navigation-menu-bearframework-addon/v/stable)](https://packagist.org/packages/ivopetkov/navigation-menu-bearframework-addon)
[![codecov.io](https://codecov.io/github/ivopetkov/navigation-menu-bearframework-addon/coverage.svg?branch=master)](https://codecov.io/github/ivopetkov/navigation-menu-bearframework-addon?branch=master)
[![License](https://poser.pugx.org/ivopetkov/navigation-menu-bearframework-addon/license)](https://packagist.org/packages/ivopetkov/navigation-menu-bearframework-addon)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c3d43639c8594403b8063549ce6e87eb)](https://www.codacy.com/app/ivo_2/navigation-menu-bearframework-addon)

## Download and install

**Install via Composer**

```shell
composer require ivopetkov/navigation-menu-bearframework-addon
```

**Download an archive**

Download the [latest release](https://github.com/ivopetkov/navigation-menu-bearframework-addon/releases) from the [GitHub page](https://github.com/ivopetkov/navigation-menu-bearframework-addon) and include the autoload file.
```php
include '/path/to/the/addon/autoload.php';
```

## Enable the addon
Enable the addon for your Bear Framework application.

```php
$app->addons->add('ivopetkov/navigation-menu-bearframework-addon');
```


## Usage

```html
<component src="navigation-menu">
    <ul>
        <li><a>Button 1</a></li>
        <li><a>Button 2</a>
            <ul>
                <li><a>Button 2.1</a></li>
                <li><a>Button 2.2</a></li>
                <li><a>Button 2.3</a></li>
            </ul>
        </li>
        <li><a>Button 3</a></li>
    </ul>
</component>
```

### Attributes

`type`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The type of the navigation. Available values: horizontal-down, vertical-left, vertical-right, list-vertical, list-horizontal

`moreItemHtml`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The HTML code for the more item. Must contain li and ul tags. Example: <li><a>...</a><ul></ul></li>

`class`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HTML class attribute value

`style`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HTML style attribute value

### Examples

The navigation will be horizontal and submenus will show bellow. If there are too many first level items, a more item will be shown.
```html
<component src="navigation-menu" type="horizontal-down">
    <ul>
        <li><a>Button 1</a></li>
        <li><a>Button 2</a>
            <ul>
                <li><a>Button 2.1</a></li>
                <li><a>Button 2.2</a></li>
                <li><a>Button 2.3</a></li>
            </ul>
        </li>
        <li><a>Button 3</a></li>
    </ul>
</component>
```

The navigation will be vertical and submenus will open to the right.
```html
<component src="navigation-menu" type="vertical-right">
    <ul>
        <li><a>Button 1</a></li>
        <li><a>Button 2</a>
            <ul>
                <li><a>Button 2.1</a></li>
                <li><a>Button 2.2</a></li>
                <li><a>Button 2.3</a></li>
            </ul>
        </li>
        <li><a>Button 3</a></li>
    </ul>
</component>

## License
Navigation menu addon for Bear Framework is open-sourced software. It's free to use under the MIT license. See the [license file](https://github.com/ivopetkov/navigation-menu-bearframework-addon/blob/master/LICENSE) for more information.

## Author
This addon is created by Ivo Petkov. Feel free to contact me at [@IvoPetkovCom](https://twitter.com/IvoPetkovCom) or [ivopetkov.com](https://ivopetkov.com).
