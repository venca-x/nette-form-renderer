# nette-form-renderer
[![Build Status](https://travis-ci.org/venca-x/nette-form-renderer.svg?branch=master)](https://travis-ci.org/venca-x/nette-form-renderer)
[![Coverage Status](https://coveralls.io/repos/github/venca-x/nette-form-renderer/badge.svg?branch=master)](https://coveralls.io/github/venca-x/nette-form-renderer?branch=master)
[![Latest Stable Version](https://poser.pugx.org/venca-x/nette-form-renderer/v/stable)](https://packagist.org/packages/venca-x/nette-form-renderer)
[![Total Downloads](https://poser.pugx.org/venca-x/nette-form-renderer/downloads)](https://packagist.org/packages/venca-x/nette-form-renderer)
[![Latest Unstable Version](https://poser.pugx.org/venca-x/nette-form-renderer/v/unstable)](https://packagist.org/packages/venca-x/nette-form-renderer)
[![License](https://poser.pugx.org/venca-x/nette-form-renderer/license)](https://packagist.org/packages/venca-x/nette-form-renderer)

Form renderer for Nette Forms - TwitterBootstrap v4

Types of orientation form
 * Vertical
 * Horizontal
 * Inline

Default is vertical form orientation.

## Vertical orientation form
```php
$form = new Form;
$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());

$form->addEmail('exampleInputEmail1', 'Email address:')
    ->setAttribute('placeholder', 'Enter email')
    ->setOption('description', 'We\'ll never share your email with anyone else.');
$form->addPassword('exampleInputPassword1', 'Password')
    ->setAttribute('placeholder', 'Password');
$form->addCheckbox('checkbox', 'Check me out');
$form->addCheckbox('checkbox2', 'Check me out2');

$form->addRadioList('country', 'Country', [
    'cz' => 'Česká republika',
    'sk' => 'Slovensko',
    'eu' => 'EU',
]);

$form->addEmail('exampleInputEmail2', 'Email address')
    ->setAttribute('placeholder', 'name@example.com');

$form->addSelect('exampleSelect', 'Example select', [
    '1',
    '2',
    '3',
    '4',
    '5', ]);

$form->addMultiSelect('exampleMultipleSelect', 'Example multiple select', [
    '1',
    '2',
    '3',
    '4',
    '5', ]);

$form->addTextArea('textarea', 'Example textarea');

$form->addUpload('upload', 'Example upload');

$form->addMultiUpload('multiUpload', 'Example multiUpload');


//sizes
$form->addEmail('formControlLg', '.form-control-lg')
    ->setAttribute('class', 'form-control-lg')
    ->setAttribute('placeholder', '.form-control-lg');

$form->addEmail('formControl', '.form-control')
    ->setAttribute('placeholder', 'Default input');

$form->addEmail('formControlSm', '.form-control-sm')
    ->setAttribute('class', 'form-control-sm')
    ->setAttribute('placeholder', '.form-control-sm');


//sizes select
$form->addSelect('largeSelect', 'Large select', ['Large select'])
    ->setAttribute('class', 'form-control-lg');

$form->addSelect('defaultSelect', ' Default select', ['Default select']);

$form->addSelect('smallSelect', 'Small select', ['Small select'])
    ->setAttribute('class', 'form-control-sm');


//disables
$form->addText('disabled', 'Disabled:')
    ->setAttribute('placeholder', 'Disabled input here…')
    ->setDisabled(true);


$form->addSubmit('submit', 'Submit')->setAttribute('class', 'btn btn-primary');
```
## Horizontal orientation form
```php
$form = new Form;
$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());

//horizontal form
$renderer = $form->getRenderer();
$renderer->setFormHorizontalOrientation();

//$renderer->setFormControlLabelWidth('col-sm-6');
//$renderer->setFormControlContainerWidth('col-sm-6');

$form->addEmail('exampleInputEmail1', 'Email address:')
    ->setAttribute('placeholder', 'Enter email')
    ->setOption('description', 'We\'ll never share your email with anyone else.');
$form->addPassword('exampleInputPassword1', 'Password')
    ->setAttribute('placeholder', 'Password');
$form->addCheckbox('checkbox', 'Check me out');
$form->addCheckbox('checkbox2', 'Check me out2');

$form->addRadioList('country', 'Country', [
    'cz' => 'Česká republika',
    'sk' => 'Slovensko',
    'eu' => 'EU',
]);

$form->addEmail('exampleInputEmail2', 'Email address')
    ->setAttribute('placeholder', 'name@example.com');

$form->addSelect('exampleSelect', 'Example select', [
    '1',
    '2',
    '3',
    '4',
    '5', ]);

$form->addMultiSelect('exampleMultipleSelect', 'Example multiple select', [
    '1',
    '2',
    '3',
    '4',
    '5', ]);

$form->addTextArea('textarea', 'Example textarea');

$form->addUpload('upload', 'Example upload');

$form->addMultiUpload('multiUpload', 'Example multiUpload');

//sizes
$form->addEmail('formControlLg', '.form-control-lg')
    ->setAttribute('class', 'form-control-lg')
    ->setAttribute('placeholder', '.form-control-lg');

$form->addEmail('formControl', '.form-control')
    ->setAttribute('placeholder', 'Default input');

$form->addEmail('formControlSm', '.form-control-sm')
    ->setAttribute('class', 'form-control-sm')
    ->setAttribute('placeholder', '.form-control-sm');


//sizes select
$form->addSelect('largeSelect', 'Large select', ['Large select'])
    ->setAttribute('class', 'form-control-lg');

$form->addSelect('defaultSelect', ' Default select', ['Default select']);

$form->addSelect('smallSelect', 'Small select', ['Small select'])
    ->setAttribute('class', 'form-control-sm');


//disables
$form->addText('disabled', 'Disabled:')
    ->setAttribute('placeholder', 'Disabled input here…')
    ->setDisabled(true);


$form->addSubmit('submit', 'Submit')->setAttribute('class', 'btn btn-primary');

return $form;
``` 
## Inline orientation form
```php
$form = new Form;
$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());

//inline form
$renderer = $form->getRenderer();
$renderer->setFormInline();

$form->addEmail('loginemail', 'E-mail address:')
    ->setAttribute('placeholder', 'Enter e-mail');
$form->addPassword('password', 'Password')
    ->setAttribute('placeholder', 'Password');
$form->addCheckbox('checkbox', 'Check me out');

$form->addSubmit('submit', 'Login')->setAttribute('class', 'btn btn-primary');
```