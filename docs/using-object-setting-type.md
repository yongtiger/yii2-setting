# Using object setting type

> Note: The following usages use the demo database. You have to custumize your own setting table before practical use!

Considering both the scalability and ease of use, we use **JSON Object**, not serialization. **JSON Object** can be easily convert into a php object with PHP ***`json_decode()`***.

- JSON Object: `'{"0":1,"age":18}', '{"0":1,"age":["name",1,["age",{"0":1,"age":18}]]}'`

|**Category**   |**Key**        |**Value**      |**Type**       |
|:-------------:|:-------------:|:-------------:|:-------------:|
|user|pofile4|{"0":1,"age":18}|object|
|user|pofile5|{"0":1,"age":["name",1,["age",{"0":1,"age":18}]]}|object|

> Note: Numeric key is NOT recommended when using **JSON Object**!

```php
///Get a setting of object type
$mySetting = \yongtiger\setting\Setting::get('user', 'profile4');
///Return an object:
// object(stdClass)#60 (2) {
//   ["0"]=>
//   int(1)
//   ["age"]=>
//   int(18)
// }

///Get a setting of object type
$mySetting = \yongtiger\setting\Setting::get('user', 'profile5');
///Return an object:
// object(stdClass)#65 (2) {
//   ["0"]=>
//   int(1)
//   ["age"]=>
//   array(3) {
//     [0]=>
//     string(4) "name"
//     [1]=>
//     int(1)
//     [2]=>
//     array(2) {
//       [0]=>
//       string(3) "age"
//       [1]=>
//       object(stdClass)#67 (2) {
//         ["0"]=>
//         int(1)
//         ["age"]=>
//         int(18)
//       }
//     }
//   }
// }
```
