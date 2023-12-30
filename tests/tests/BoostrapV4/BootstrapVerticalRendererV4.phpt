<?php

declare(strict_types=1);

namespace Test\BoostrapV4;

use Nette\Forms\Form;
use Tester;
use Tester\Assert;
use VencaX;

require __DIR__ . '/../../bootstrap.php';

class BootstrapVerticalRendererV4 extends Tester\TestCase
{
	private function createBaseFormWithRenderer()
	{
		$form = new Form();
		$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());
		return $form;
	}


	public function testVerticalForm()
	{
		$form = $this->createBaseFormWithRenderer();

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../../expected/bootstrap-v4/form-vertical.html', (string) $form);
	}


	public function testVerticalTwoForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//vertical form
		$renderer = $form->getRenderer();
		$renderer->setFormVerticalOrientation();

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../../expected/bootstrap-v4/form-vertical.html', (string) $form);
	}


	private function addInputs(Form $form): Form
	{
		$form->addEmail('exampleInputEmail1', 'Email address:')
			->setHtmlAttribute('placeholder', 'Enter email')
			->setOption('description', 'We\'ll never share your email with anyone else.');
		$form->addPassword('exampleInputPassword1', 'Password')
			->setHtmlAttribute('placeholder', 'Password');
		$form->addCheckbox('checkbox', 'Check me out');
		$form->addCheckbox('checkbox2', 'Check me out2');

		$form->addRadioList('country', 'Country', [
			'cz' => 'Česká republika',
			'sk' => 'Slovensko',
			'eu' => 'EU',
		]);

		$form->addEmail('exampleInputEmail2', 'Email address')
			->setHtmlAttribute('placeholder', 'name@example.com');

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
			->setHtmlAttribute('class', 'form-control-lg')
			->setHtmlAttribute('placeholder', '.form-control-lg');

		$form->addEmail('formControl', '.form-control')
			->setHtmlAttribute('placeholder', 'Default input');

		$form->addEmail('formControlSm', '.form-control-sm')
			->setHtmlAttribute('class', 'form-control-sm')
			->setHtmlAttribute('placeholder', '.form-control-sm');


		//sizes select
		$form->addSelect('largeSelect', 'Large select', ['Large select'])
			->setHtmlAttribute('class', 'form-control-lg');

		$form->addSelect('defaultSelect', ' Default select', ['Default select']);

		$form->addSelect('smallSelect', 'Small select', ['Small select'])
			->setHtmlAttribute('class', 'form-control-sm');


		//disables
		$form->addText('disabled', 'Disabled:')
			->setHtmlAttribute('placeholder', 'Disabled input here…')
			->setDisabled(true);


		$form->addSubmit('submit', 'Submit')->setHtmlAttribute('class', 'btn btn-primary');

		return $form;
	}


	public function testVerticalCheckInlineForm()
	{
		$form = $this->createBaseFormWithRenderer();

		$form->addCheckbox('mondayCheckbox', 'Monday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('tuesdayCheckbox', 'Tuesday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('wednesdayCheckbox', 'Wednesday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('thurstdayCheckbox', 'Thurstday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('fridayCheckbox', 'Friday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('saturdayCheckbox', 'Saturday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);
		$form->addCheckbox('sundayCheckbox', 'Sunday')->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);

		$form->addRadioList('weekRadio', 'Week radio', [
			'monday' => 'Monday',
			'tuesday' => 'Tuesday',
			'wednesday' => 'Wednesday',
			'thurstday' => 'Thurstday',
			'friday' => 'Friday',
			'saturday' => 'Saturday',
			'sunday' => 'Sunday',
		])->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);

		$html = (string) $form;

		//Assert::same('', (string) $html);

		$dom = Tester\DomQuery::fromHtml($html);

		$this->checkInlineCheckbox($dom, 0, 'Monday');
		$this->checkInlineCheckbox($dom, 1, 'Tuesday');
		$this->checkInlineCheckbox($dom, 2, 'Wednesday');
		$this->checkInlineCheckbox($dom, 3, 'Thurstday');
		$this->checkInlineCheckbox($dom, 4, 'Friday');
		$this->checkInlineCheckbox($dom, 5, 'Saturday');
		$this->checkInlineCheckbox($dom, 6, 'Sunday');

		Assert::same('Week radio', (string) $dom->find('fieldset legend label')[0]);
		Assert::same('form-check form-check-inline', (string) $dom->find('div.form-check')[8]->attributes()['class']);
		$this->checkInlineRadio($dom, 7, 'Monday');
		$this->checkInlineRadio($dom, 8, 'Tuesday');
		$this->checkInlineRadio($dom, 9, 'Wednesday');
		$this->checkInlineRadio($dom, 10, 'Thurstday');
		$this->checkInlineRadio($dom, 11, 'Friday');
		$this->checkInlineRadio($dom, 12, 'Saturday');
	}


	public function testVerticalInlineForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//inline form
		$renderer = $form->getRenderer();
		$renderer->setFormInline();

		$form->addEmail('loginemail', 'E-mail address:')
			->setHtmlAttribute('placeholder', 'Enter e-mail');
		$form->addPassword('password', 'Password')
			->setHtmlAttribute('placeholder', 'Password');
		$form->addCheckbox('checkbox', 'Check me out');

		$form->addSubmit('submit', 'Login')->setHtmlAttribute('class', 'btn btn-primary');

		$html = (string) $form;

		//Assert::same('', (string) $html);

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::same('form-inline', (string) $dom->find('form.form-inline')[0]->attributes()['class']);

		Assert::same('form-control mb-2 mr-sm-2 mb-sm-0', (string) $dom->find('input')[0]->attributes()['class']);
		Assert::same('form-control mb-2 mr-sm-2 mb-sm-0', (string) $dom->find('input')[1]->attributes()['class']);
		Assert::same('form-check-input', (string) $dom->find('input')[2]->attributes()['class']);
		Assert::same('form-check mb-2 mr-sm-2 mb-sm-0', (string) $dom->find('div')[2]->attributes()['class']);
	}


	private function checkInlineCheckbox($dom, $position, $label)
	{
		Assert::contains('form-check form-check-inline', (string) $dom->find('div.form-check.form-check-inline')[$position]->attributes()['class']);
		Assert::same($label, (string) $dom->find('div label')[$position]);
		Assert::contains('form-check-label', (string) $dom->find('div label')[$position]->attributes()['class']);
		Assert::contains('form-check-input', (string) $dom->find('div input')[$position]->attributes()['class']);
	}


	private function checkInlineRadio($dom, $position, $label)
	{
		Assert::contains($label, (string) $dom->find('div.form-check label')[$position]);
		Assert::contains('form-check-label', (string) $dom->find('div.form-check label')[$position]->attributes()['class']);
		Assert::contains('form-check-input', (string) $dom->find('div input')[$position]->attributes()['class']);
	}
}

$test = new BootstrapVerticalRendererV4();
$test->run();
