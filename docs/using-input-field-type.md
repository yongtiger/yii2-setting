# Using input field type

> Note: The following usages use the demo database. You have to custumize your own setting table before practical use!

```php
const INPUT_TEXTINPUT = 'textInput';
const INPUT_TEXTAREA = 'textarea';

const INPUT_RADIO = 'radio';
const INPUT_RADIOLIST = 'radioList';

const INPUT_CHECKBOX = 'checkbox';
const INPUT_CHECKBOXLIST = 'checkboxList';          ///multiple-select

const INPUT_LISTBOX = 'listBox';                    ///sub-array nested
const INPUT_LISTBOX_MULTIPLE = 'multiselect';       ///multiple-select, sub-array nested

const INPUT_DROPDOWNLIST = 'dropdownList';          ///sub-array nested
const INPUT_DROPDOWNLIST_MULTIPLE = 'multiselect';  ///multiple-select, sub-array nested    ///same as INPUT_LISTBOX_MULTIPLE
```

> Note: Taking into account the expansion of compatibility, using [`\kartik\widgets\ActiveForm`](http://demos.krajee.com/builder-details/form#settings) naming.

(TBD)
