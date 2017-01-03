# Using array setting type

> Note: The following usages use the demo database. You have to custumize your own setting table before practical use!

Considering both the scalability and ease of use, we use **JSON Array**, not a string like `'aaa|bbb|ccc'`, which is not support sub-array. **JSON Array** can be easily convert into an php array with PHP function ***`json_decode()`***.

- JSON Array without key: `'["age",1]', '["name",1,["age",1]]', '["name",1,["age",{"0":1,"age":18}]]'`
- JSON Array with a key (actually is a **JSON Object**, need type-castting into php array): `'{"0":1,"age":18}', '{"0":1,"age":["name",1,["age",{"0":1,"age":18}]]}'`

|**Category**   |**Key**        |**Value**      |**Type**       |
|:-------------:|:-------------:|:-------------:|:-------------:|
|user|pofile1|["age",1]|array|
|user|pofile2|["name",1,["age",1]]|array|
|user|pofile3|["name",1,["age",{"0":1,"age":18}]]|array|

> Note: Numeric key is NOT recommended when using **JSON Object** or **JSON Array** with a key!

> Note: Inner **JSON Object** will NOT be converted into sub-array!

```php
///Get a setting of array type
$mySetting = \yongtiger\setting\Setting::get('user', 'profile1');
///Return an array:
// array(2) {
//   [0]=>
//   string(3) "age"
//   [1]=>
//   int(1)
// }

///Get a setting of array type
$mySetting = \yongtiger\setting\Setting::get('user', 'profile2');
///Return an array:
// array(3) {
//   [0]=>
//   string(4) "name"
//   [1]=>
//   int(1)
//   [2]=>
//   array(2) {
//     [0]=>
//     string(3) "age"
//     [1]=>
//     int(1)
//   }
// }

///Get a setting of array type
$mySetting = \yongtiger\setting\Setting::get('user', 'profile3');
///Return an array:
// array(3) {
//   [0]=>
//   string(4) "name"
//   [1]=>
//   int(1)
//   [2]=>
//   array(2) {
//     [0]=>
//     string(3) "age"
//     [1]=>
//     object(stdClass)#60 (2) {
//       ["0"]=>
//       int(1)
//       ["age"]=>
//       int(18)
//     }
//   }
// }
```
