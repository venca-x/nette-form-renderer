<?php

declare(strict_types=1);

namespace Test;

use Nette\Forms\Form;
use Nette\Utils\Html;
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


	public function testVerticalCheckInlineForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//test html description
		$form->addEmail('exampleInputEmail1', 'Email address:')
			->setAttribute('placeholder', 'Enter email')
			->setOption('description', Html::el('strong', 'E-mail'));

		$html = (string) $form;

		//Assert::same('', (string) $html);

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::same('E-mail', (string) $dom->find('strong')[0]);
	}
}

$test = new BootstrapVerticalRendererV4();
$test->run();
