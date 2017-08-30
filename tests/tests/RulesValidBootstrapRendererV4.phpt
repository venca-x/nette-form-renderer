<?php

declare(strict_types=1);

namespace Test;

use Nette;
use Nette\Forms\Form;
use Nette\Utils\Html;
use Tester;
use Tester\Assert;
use VencaX;


require __DIR__ . '/../bootstrap.php';

class RulesValidBootstrapRendererV4 extends Tester\TestCase
{
	public function testInvalidArgumentException()
	{
		Assert::exception(function () {
			$form = new Form;
			$form->addText('foo')
				->addRule(Form::VALID);
		}, Nette\InvalidArgumentException::class, 'You cannot use Form::VALID in the addRule method.');
	}

	public function testDescriptionHtml()
	{
		$form = $this->createBaseFormWithRenderer();

		$form->addEmail('exampleInputEmail1', 'Email address:')
			->setOption('description', Html::el()->setHtml('vencax@gmail.com'));

		$html = (string) $form;
		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('input[name="exampleInputEmail1"]'));
		Assert::same('vencax@gmail.com',(string)$dom->find('small')[0]);
	}


	private function createBaseFormWithRenderer()
	{
		$form = new Form;
		$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV4());
		return $form;
	}

}

$test = new RulesValidBootstrapRendererV4();
$test->run();
