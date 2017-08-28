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

		$form->addText('name', 'Name:');

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

		$form->addText('name', 'Name:');

		Assert::matchFile(__DIR__ . '/../expected/bootstrap-v4/form-horizontal-sm-6.html', (string) $form);
	}
}

$test = new BootstrapHorizontalRendererV4();
$test->run();
