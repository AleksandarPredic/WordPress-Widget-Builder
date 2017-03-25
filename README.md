# WordPress Widget Builder

The WordPress Widget Builder serves as a framework to quickly build your WordPress widgets.

* **Requires at least:** 4.0.0 

## Table of contents
1. Description
2. Features
3. Installation
4. Usage
5. Filters
6. Add custom admin form field
7. Licence
8. Chengelog
9. Developers
10. Author information


## 1. Description

The WordPress Widget Builder is a very simple framework that enables you to pass configuration array from which it will automatically create widget admin and let you worried only about widget frontend.


## 2. Features

* The Widget Bulder is fully-based on the WordPress Widget API
* Frontend rendering function receive two additional params: $form_fields and $widget_id. 

    * **$form_fields** is used to pass admin form fields configuration array so you can set default same default values for vars as it the admin form. Example: If default select form field value is set for admin form, the same value can be retreived to be default value on frontend if somehow variable is not set or any other case. It will be easier to explain through examples.

    * **$widget_id** is used to pass widget instance id so it can be used as unique id to apply custom css only for that widget instance.


## 3. Installation

#### Install as plugin

* Download and install as any other plugin. 
* Navigate to the "Plugins" dashboard page
* Activate plugin

#### Integrate into theme

1. Copy predic-widget folder into root path of your theme folder.

1. Define this constants, before including files, for all admin form fields to work.

 ```php
define( 'PREDIC_WIDGET_ROOT_URL', get_template_directory_uri() . '/predic-widget' );
define( 'PREDIC_WIDGET_ROOT_PATH', get_template_directory() . '/predic-widget');
```

1. Include files in your functions.php.

```php
include get_template_directory() . get_template_directory() . '/predic-widget';
```

1. If moving predic-widget folder to another location, please provide different path and url for previous two steps.


## 4. Usage


## 5. Filters


## 6. Add custom admin form field


## 7. Licence

The WordPress Widget Boilerplate is licensed under the GPL v2 or later.

>This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

>You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA


## 8. Chengelog


#### 1.0.0 (24th March 2017)
* Official release


## 9. Developers

Miss a feature? Pull requests are welcome.

The project is open-source and hopefully will receive contributions from awesome WordPress Developers throughout the world.


## 10. Author information

The WordPress Widget Boilerplate was originally started and is maintained by [Aleksandar Predic](https://github.com/AleksandarPredic).