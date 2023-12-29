<?php

declare(strict_types=1);

namespace Test\BoostrapV5;

use Nette\Forms\Form;
use Nette\Utils\Html;
use Tester;
use Tester\Assert;
use VencaX;

require __DIR__ . '/../../bootstrap.php';

class BootstrapVerticalRendererV5 extends Tester\TestCase
{
	private function createBaseFormWithRenderer()
	{
		$form = new Form;
		$form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV5);
		return $form;
	}


	public function testBaseForm()
	{
		$form = $this->createBaseFormWithRenderer();

		$form->addEmail('exampleFormControlInput1', 'Email address')
			->setHtmlAttribute('placeholder', 'name@example.com');

		$form->addTextArea('exampleFormControlTextarea1', 'Example textarea')
			->setRequired();

        $form->addSubmit('submit', 'Submit')->setHtmlAttribute('class', 'btn btn-primary');

		$html = (string) $form;

		Assert::matchFile(__DIR__ . '/../../expected/bootstrap-v5/form-base.html', $html);

		$dom = Tester\DomQuery::fromHtml($html);

		//labels
		Assert::same('Email address', (string) $dom->find('label')[0]);
		Assert::same('Example textarea', (string) $dom->find('label')[1]);
	}
}

$test = new BootstrapVerticalRendererV5;
$test->run();
