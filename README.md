# WordPress Widget Builder

The WordPress Widget Builder serves as a framework to quickly build your WordPress widgets.

* **Requires at least:** 4.0.0 

#### Please read our [Wiki documentation](./Wiki) also to find more details about using the framework

## Table of contents
1. [Description](#1-description)
2. [Features](#2-features)
3. [Licence](#7-licence)
4. [Chengelog](#8-chengelog)
5. [Developers](#9-developers)
6. [Author information](#10-author-information)


## 1. Description

The **WordPress Widget Builder** serves as a framework to quickly build your WordPress widgets.

You can make configuration array of desired widget name, description, fields... and the framework will create widget admin part for you. Leaving you to worry only about widget frontend output. 

In addition the framework will pass two additional parameters to your function or method that handles frontend output: **$form_fields** and **$widget_id**. See more details about them on [features page](./Wiki/Features).

Minimum required WordPress version is 4.0.0


## 2. Features

* The Widget Bulder is fully-based on the [WordPress Widget API](https://codex.wordpress.org/Widgets_API).
* Widget admin is automatically created from [configuration array](./Wiki/Usage).
* Frontend rendering function receive two additional params: $form_fields and $widget_id. 

    * **$form_fields** is used to pass admin form fields configuration array so you can set default same default values for vars as it the admin form. Example: If default select form field value is set for admin form, the same value can be retreived to be default value on frontend if somehow variable is not set or any other case. It will be easier to explain through examples.

    * **$widget_id** is used to pass widget instance id so it can be used as unique id to apply custom css only for that widget instance.

* You can use function or class method to handle frontend output.


## 3. Licence

The WordPress Widget Boilerplate is licensed under the GPL v2 or later.

>This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

>You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA


## 4. Chengelog


#### 1.0.0 (24th March 2017)
* Official release


## 5. Developers

Miss a feature? Pull requests are welcome.

The project is open-source and hopefully will receive contributions from awesome WordPress Developers throughout the world.


## 6. Author information

The WordPress Widget Boilerplate was originally started and is maintained by [Aleksandar Predic](https://github.com/AleksandarPredic).