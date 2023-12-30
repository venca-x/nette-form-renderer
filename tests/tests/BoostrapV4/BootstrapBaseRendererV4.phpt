<?php

declare(strict_types=1);

namespace Test\BoostrapV4;

use Nette\Forms\Form;
use Nette\Utils\Html;
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


	public function testBaseForm()
	{
		$form = $this->createBaseFormWithRenderer();

		//test html description
		$form->addEmail('exampleInputEmail1', 'Email address:')
			->setHtmlAttribute('placeholder', 'Enter email')
			->setOption('description', Html::el('strong', 'E-mail'));

		//test require
		$form->addText('name', 'Jméno:')
			->setRequired('Zadejte prosím jméno');

		$html = (string) $form;

		//Assert::same('', (string) $html);

		$dom = Tester\DomQuery::fromHtml($html);

		//description
		Assert::same('E-mail', (string) $dom->find('strong')[0]);

		//require
		Assert::contains('required', (string) $dom->find('div.form-group')[1]->attributes()['class']); //.form-group has class require
		Assert::contains('required', (string) $dom->find('div.form-group label')[1]->attributes()['class']); //label has required
	}
}

$test = new BootstrapVerticalRendererV4();
$test->run();
