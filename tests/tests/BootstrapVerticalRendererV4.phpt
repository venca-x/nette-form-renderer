<?php

declare(strict_types=1);

namespace Test;

use Nette\Forms\Form;
use Tester;
use Tester\Assert;
use VencaX;

require __DIR__ . '/../bootstrap.php';

class BootstrapVerticalRendererV4 extends Tester\TestCase
{
	private function createBaseFormWithRenderer()
	{
		$form = new Form;
		$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());
		return $form;
	}


	public function testVerticalForm()
	{
		$form = $this->createBaseFormWithRenderer();

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../expected/bootstrap-v4/form-vertical.html', (string) $form);
	}


	public function testVerticalTwoForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//vertical form
		$renderer = $form->getRenderer();
		$renderer->setFormVerticalOrientation();

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../expected/bootstrap-v4/form-vertical.html', (string) $form);
	}


	public function testVerticalCheckInlineForm()
	{
		$form = $this->createBaseFormWithRenderer();

		$form->addCheckbox('mondayCheckbox', 'Monday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('tuesdayCheckbox', 'Tuesday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('wednesdayCheckbox', 'Wednesday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('thurstdayCheckbox', 'Thurstday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('fridayCheckbox', 'Friday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('saturdayCheckbox', 'Saturday')->setOption('orientation', 'form-check-inline');
		$form->addCheckbox('sundayCheckbox', 'Sunday')->setOption('orientation', 'form-check-inline');

		$form->addRadioList('weekRadio', 'Week radio', [
			'monday' => 'Monday',
			'tuesday' => 'Tuesday',
			'wednesday' => 'Wednesday',
			'thurstday' => 'Thurstday',
			'friday' => 'Friday',
			'saturday' => 'Saturday',
			'sunday' => 'Sunday',
		])->setOption('orientation', 'form-check-inline');

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

		Assert::same('Week radio', (string) $dom->find('div.form-check')[7]);
		$this->checkInlineRadio($dom, 7, 'Monday');
		$this->checkInlineRadio($dom, 8, 'Tuesday');
		$this->checkInlineRadio($dom, 9, 'Wednesday');
		$this->checkInlineRadio($dom, 10, 'Thurstday');
		$this->checkInlineRadio($dom, 11, 'Friday');
		$this->checkInlineRadio($dom, 12, 'Saturday');
	}


	private function checkInlineCheckbox($dom, $position, $label)
	{
		Assert::contains('form-check form-check-inline', (string) $dom->find('div.form-check.form-check-inline')[$position]->attributes()['class']);
		Assert::same($label, (string) $dom->find('div label')[$position]);
		Assert::contains('form-check-label', (string) $dom->find('div label')[$position]->attributes()['class']);
		Assert::contains('form-check-input', (string) $dom->find('div label input')[$position]->attributes()['class']);
	}


	private function checkInlineRadio($dom, $position, $label)
	{
		Assert::contains('form-check form-check-inline', (string) $dom->find('div.form-check.form-check-inline')[$position]->attributes()['class']);
		Assert::same($label, (string) $dom->find('div label')[$position]);
		Assert::contains('form-check-label', (string) $dom->find('div label')[$position]->attributes()['class']);
		Assert::contains('form-check-input', (string) $dom->find('div label input')[$position]->attributes()['class']);
	}


	/**
	 * @param Form $form
	 * @return Form
	 */
	private function addInputs(Form $form): Form
	{
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
	}
}

$test = new BootstrapVerticalRendererV4();
$test->run();
