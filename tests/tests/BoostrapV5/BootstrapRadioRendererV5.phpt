<?php

declare(strict_types=1);

namespace Test\BoostrapV5;

use Nette\Forms\Form;
use Tester;
use Tester\Assert;
use VencaX;

require __DIR__ . '/../../bootstrap.php';

class BootstrapRadioRendererV5 extends Tester\TestCase
{
	public function testRadioForm()
	{
		$form = $this->createBaseFormWithRenderer();

        $form->addRadioList('country', 'Country', [
            'cz' => 'Česká republika',
            'sk' => 'Slovensko',
            'eu' => 'EU',
        ]);

        $form->addRadioList('weekRadionline', 'Week radio 2', [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thurstday' => 'Thurstday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ])->setOption('orientation', VencaX\NetteFormRenderer\BootstrapRendererV4::FORM_CHECK_INLINE);

		$form->addSubmit('submit', 'Submit')->setHtmlAttribute('class', 'btn btn-primary');

		$html = (string) $form;

		Assert::matchFile(__DIR__ . '/../../expected/bootstrap-v5/form-radio.html', $html);
	}


    private function createBaseFormWithRenderer()
    {
        $form = new Form();
        $form->setRenderer(new VencaX\NetteFormRenderer\BootstrapRendererV5());
        return $form;
    }
}

$test = new BootstrapRadioRendererV5();
$test->run();
