# Using basic setting type

> Note: The following usages use the demo database. You have to custumize your own setting table before practical use!

|**Category**   |**Key**        |**Value**      |**Type**       |
|:-------------:|:-------------:|:-------------:|:-------------:|
|site|name|My Application|string|
|user|age|18|integer|
|user|height|178.5|float|
|user|married|1|boolean|

> Note: Only `category`, `key`, `value` and `type` fields are used in the frontend!

```php
///Get a setting of string type
$mySetting = \yongtiger\setting\Setting::get('site', 'name');
///Return a string, e.g. 'My Application'

///Get a setting of integer type
$mySetting = \yongtiger\setting\Setting::get('user', 'age');
///Return a int, e.g. 18

///Get a setting of float type
$mySetting = \yongtiger\setting\Setting::get('user', 'height');
///Return a float/double, e.g. 178.5

///Get a setting of boolean type
$mySetting = \yongtiger\setting\Setting::get('user', 'married');
///Return a bool, e.g. true
```

