<?php

declare(strict_types=1);

namespace Test;

use Nette\Forms\Form;
use Tester;
use Tester\Assert;
use VencaX;

require __DIR__ . '/../bootstrap.php';

class BootstrapHorizontalRendererV4 extends Tester\TestCase
{
	private function createBaseFormWithRenderer()
	{
		$form = new Form;
		$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());
		return $form;
	}


	public function testHorizontalForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//horizontal form
		$renderer = $form->getRenderer();
		$renderer->setFormHorizontalOrientation();

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../expected/bootstrap-v4/form-horizontal.html', (string) $form);
	}


	public function testHorizontalFormSm6()
	{
		$form = $this->createBaseFormWithRenderer();

		//horizontal form
		$renderer = $form->getRenderer();
		$renderer->setFormHorizontalOrientation();

		$renderer->setFormControlLabelWidth('col-sm-6');
		$renderer->setFormControlContainerWidth('col-sm-6');

		$form = $this->addInputs($form);

		Assert::matchFile(__DIR__ . '/../expected/bootstrap-v4/form-horizontal-sm-6.html', (string) $form);
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


		$form->addSubmit('submit', 'Submit')->setAttribute('class', 'btn btn-primary');

		return $form;
	}
}

$test = new BootstrapHorizontalRendererV4();
$test->run();
