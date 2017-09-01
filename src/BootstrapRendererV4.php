<?php

declare(strict_types=1);

namespace VencaX\NetteFormRenderer;

use Nette;
use Nette\Utils\Html;

class BootstrapRendererV4 extends Nette\Forms\Rendering\DefaultFormRenderer
{

	/**
	 * Default is vertical orientation form
	 * @var bool
	 */
	private $formOrientationVertical = true;

	private $formControlContainerWidth = 'col-sm-9';
	private $formControlLabelWidth = 'col-sm-3';


	/**
	 * Renders form begin.
	 */
	public function renderBegin(): string
	{
		$this->wrappers['controls']['container'] = null;
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['pair']['container'] = 'div class="form-group"';//vertical
		} else {
			$this->wrappers['pair']['container'] = 'div class="form-group row"';//horizontal
		}
		$this->wrappers['pair']['.error'] = 'has-danger';
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['control']['container'] = null;//vertical
		} else {
			$this->wrappers['control']['container'] = 'div class="' . $this->formControlContainerWidth . '"';//horizontal
		}
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['label']['container'] = null;//vertical
		} else {
			$this->wrappers['label']['container'] = 'div class="' . $this->formControlLabelWidth . ' col-form-label"';//horizontal
		}
		$this->wrappers['control']['checkbox'] = 'div class="form-check"';
		$this->wrappers['control']['description'] = 'small';
		$this->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
		$this->wrappers['control']['.text'] = $this->wrappers['control']['.text'] . ' form-control';
		$this->wrappers['control']['.password'] = $this->wrappers['control']['.password'] . ' form-control';
		$this->wrappers['control']['.file'] = $this->wrappers['control']['.file'] . ' form-control';
		$this->wrappers['control']['.email'] = $this->wrappers['control']['.email'] . ' form-control';
		$this->wrappers['control']['.number'] = $this->wrappers['control']['.number'] . ' form-control';
		$this->wrappers['control']['.checkbox'] = 'form-check-input';

		return parent::renderBegin();
	}


	/**
	 * Set vertical form oriantation (is default)
	 */
	public function setFormVerticalOrientation()
	{
		$this->formOrientationVertical = true;
	}


	/**
	 * Set horizontal form oriantation
	 */
	public function setFormHorizontalOrientation()
	{
		$this->formOrientationVertical = false;
	}


	/**
	 * Is form in vertical orientation
	 * @return bool
	 */
	private function isFormVerticalOrientation(): bool
	{
		return $this->formOrientationVertical;
	}


	/**
	 * @param string $formControlContainerWidth
	 */
	public function setFormControlContainerWidth(string $formControlContainerWidth)
	{
		$this->formControlContainerWidth = $formControlContainerWidth;
	}


	/**
	 * @param string $formControlLabelWidth
	 */
	public function setFormControlLabelWidth(string $formControlLabelWidth)
	{
		$this->formControlLabelWidth = $formControlLabelWidth;
	}


	/**
	 * Renders single visual row.
	 */
	public function renderPair(Nette\Forms\IControl $control): string
	{
		if ($control->getOption('type') === 'checkbox') {
			$pair = $this->getWrapper('control checkbox');

			if( $control->getOption('orientation', null) != null) {
				$pair->class('form-check-inline', true);
			}

		} else {
			$pair = $this->getWrapper('pair container');
		}
		$pair->addHtml($this->renderLabel($control));
		$pair->addHtml($this->renderControl($control));
		$pair->class($this->getValue($control->isRequired() ? 'pair .required' : 'pair .optional'), true);
		$pair->class($control->hasErrors() ? $this->getValue('pair .error') : null, true);
		$pair->class($control->getOption('class'), true);
		if (++$this->counter % 2) {
			$pair->class($this->getValue('pair .odd'), true);
		}
		$pair->id = $control->getOption('id');
		return $pair->render(0);
	}


	/**
	 * Renders single visual row of multiple controls.
	 * @param  Nette\Forms\IControl[]
	 */
	public function renderPairMulti(array $controls): string
	{
		$s = [];
		foreach ($controls as $control) {
			if (!$control instanceof Nette\Forms\IControl) {
				throw new Nette\InvalidArgumentException('Argument must be array of Nette\Forms\IControl instances.');
			}
			$description = $control->getOption('description');
			if ($description instanceof IHtmlString) {
				$description = ' ' . $description;

			} elseif ($description != null) { // intentionally ==
				if ($control instanceof Nette\Forms\Controls\BaseControl) {
					$description = $control->translate($description);
				}
				$description = ' ' . $this->getWrapper('control description')->setText($description);

			} else {
				$description = '';
			}

			$control->setOption('rendered', true);
			$el = $control->getControl();
			if ($el instanceof Html && $el->getName() === 'input') {
				$el->class($this->getValue("control .$el->type"), true);
			}
			$s[] = $el . $description;
		}
		if ($this->isFormVerticalOrientation()) {
			//is vertical form
			$pair = Html::el('');
		} else {
			//is horizontal form
			$pair = $this->getWrapper('pair container');
		}
		$pair->addHtml($this->renderLabel($control));
		$pair->addHtml($this->getWrapper('control container')->setHtml(implode(' ', $s)));
		return $pair->render(0);
	}


	/**
	 * Renders 'label' part of visual row of controls.
	 */
	public function renderLabel(Nette\Forms\IControl $control): Html
	{
		if ($control->getOption('type') === 'button') {
			//none label for label
			return Html::el('');
		} else {
			$suffix = $this->getValue('label suffix') . ($control->isRequired() ? $this->getValue('label requiredsuffix') : '');
			$label = $control->getLabel();
			if ($label instanceof Html) {
				$label->addHtml($suffix);
				if ($control->isRequired()) {
					$label->class($this->getValue('control .required'), true);
				}
			} elseif ($label != null) { // @intentionally ==
				$label .= $suffix;
			}
			return $this->getWrapper('label container')->setHtml((string) $label);
		}
	}


	/**
	 * Renders 'control' part of visual row of controls.
	 */
	public function renderControl(Nette\Forms\IControl $control): Html
	{
		$body = $this->getWrapper('control container');
		if ($this->counter % 2) {
			$body->class($this->getValue('control .odd'), true);
		}

		$description = $control->getOption('description');
		if ($description instanceof IHtmlString) {
			$description = ' ' . $description;

		} elseif ($description != null) { // intentionally ==
			if ($control instanceof Nette\Forms\Controls\BaseControl) {
				$description = $control->translate($description);
			}
			$description = ' ' . $this->getWrapper('control description')->setText($description);

		} else {
			$description = '';
		}

		if ($control->isRequired()) {
			$description = $this->getValue('control requiredsuffix') . $description;
		}

		$control->setOption('rendered', true);
		if (in_array($control->getOption('type'), ['checkbox', 'radio'], true)) {
			if ($control instanceof Nette\Forms\Controls\Checkbox) {
				$control->getLabelPrototype()->addClass('form-check-label');
			} else {
				$control->getItemLabelPrototype()->addClass('form-check-label');
			}
			$control->getControlPrototype()->addClass('form-check-input');
		}

		$el = $control->getControl();

		if ($control->getOption('type') === 'text' || $control->getOption('type') === 'textarea' || $control->getOption('type') === 'select') {
			$el->class('form-control', true);
		} elseif ($control->getOption('type') === 'file') {
			$el->class('form-control-file', true);
		} else {
			$el->class($this->getValue("control .$el->type"), true);
		}

		return $body->setHtml($el . $description . $this->renderErrors($control));
	}
}
