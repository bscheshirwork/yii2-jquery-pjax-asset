# Asset for origin defunkt/jquery-pjax

This asset propose use original [defunkt/jquery-pjax](https://github.com/defunkt/jquery-pjax) instead
fork [yii2 build in yiisoft/jquery-pjax](https://github.com/yiisoft/jquery-pjax)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

add

```
"bscheshirwork/yii2-jquery-pjax-asset": "@dev"
```

to the require section of your `composer.json` file.



## Usage

@see [defunkt/jquery-pjax readme](https://github.com/defunkt/jquery-pjax) for common usage

### Use directly

First: add assets to you page;
```php
<?php
bscheshirwork\y2jpa\PjaxAsset::register($this);
?>
```
Second: we can use `$.pjax` directly in JS block

for document notation
```php
<?php
$this->registerJs(new JsExpression(<<<JS
//global settings
$.pjax.defaults.timeout = 0;
//pjax links 
//(for document; click on specific `a` inside .model-index; reload area '.model-index'; inject content from first '.model-index' match in answer)
$(document).pjax('.model-index a:not(\'[data-pjax="0"]\')', '.model-index', {fragment: '.model-index'});
//pjax forms
//(for document; submit a specific `form` inside .model-index; reload area '.model-index'; inject content from first '.model-index' match in answer)
$(document).on('submit', '.model-index form:not(\'[data-pjax="0"]\')', function (event) {
    $.pjax.submit(event, '.model-index', {fragment: '.model-index'})
})
//restore js widgets
//(for document; listen a specific action at .model-index)
$(document).on('.model-index ready pjax:end', function (event) {
    //reinit already existing yiiGridView (by default code `jQuery('w0').yiiGridView` is in <script> tag and non-disabled by comment tag)
    $('script').each(function () {
        if (!this.src) {
            $.each($(this).html().match(/jQuery\('.+'\).yiiGridView\(.+\)/g) || [], function (index, value) {
                $.globalEval(value)
            })
        }
    })
})
JS
), \yii\web\View::POS_READY);
?>
```

for concrete tag
```php
<?php
$this->registerJs(new JsExpression(<<<JS
//global settings
$.pjax.defaults.timeout = 0;
//pjax links 
//(for selector; click on specific `a` inside .model-index; reload area '.model-index'; inject content from first '.model-index' match in answer)
$('.model-index').pjax('a:not(\'[data-pjax="0"]\')', '.model-index', {fragment: '.model-index'});
//pjax forms
//(for selector; submit a specific `form` inside .model-index; reload area '.model-index'; inject content from first '.model-index' match in answer)
$('.model-index').on('submit', 'form:not(\'[data-pjax="0"]\')', function (event) {
    $.pjax.submit(event, '.model-index', {fragment: '.model-index'})
})
//restore js widgets
//(for selector; listen a specific action at .model-index)
$('.model-index').on('ready pjax:end', function (event) {
    //reinit already existing yiiGridView (by default code `jQuery('w0').yiiGridView` is in <script> tag and non-disabled by comment tag)
    $('script').each(function () {
        if (!this.src) {
            $.each($(this).html().match(/jQuery\('.+'\).yiiGridView\(.+\)/g) || [], function (index, value) {
                $.globalEval(value)
            })
        }
    })
})
JS
), \yii\web\View::POS_READY);
?>
```

>Note: we can re-init your js widgets like a `yiiGridView`  

>Note: we can check sender inside `pjax:beforeSend` event listener if you wish use nested pjax blocks  
```js
$('.model-index').on('ready pjax:beforeSend', function (event) {
    console.log(event.target)
    //...
    event.preventDefault()
})
```

### Use as part of a your own widget

add `bscheshirwork\y2jpa\PjaxAsset::register($this);` to `run()` method of your widget

use your widget `id` as tag for build `$('#id').pjax('#id a', '#id', {fragment: '#id'})`expression

on server side we can croup content use `ob_start()`/`ob_end_clean()` mechanism in `widget::begin()`/`widget::end()`