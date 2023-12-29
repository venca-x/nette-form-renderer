<?php

declare(strict_types=1);

namespace VencaX\NetteFormRenderer;

use Nette;
use Nette\Utils\Html;

class BootstrapRendererV5 extends Nette\Forms\Rendering\DefaultFormRenderer
{
	public const FORM_CHECK_INLINE = 'form-check-inline';

	/**
	 * Default is vertical orientation form
	 * @var bool
	 */
	private $formOrientationVertical = true;

	/**
	 * Default is not inline form
	 * @var bool
	 */
	private $formInline = false;

	private $formControlLabelWidth = 'col-sm-3';

	private $formControlContainerWidth = 'col-sm-9';


	/**
	 * Renders form begin.
	 */
	public function renderBegin(): string
	{
		$renderer = new \stdClass;
		$renderer->wrappers['error']['container'] = 'div';
		$renderer->wrappers['error']['item'] = 'div class="alert alert-danger"';

		$this->wrappers['controls']['container'] = null;
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['pair']['container'] = 'div class="mb-3"'; //vertical
		} else {
			$this->wrappers['pair']['container'] = 'div class="form-group row"'; //horizontal
		}
		$this->wrappers['pair']['.error'] = 'has-danger';
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['control']['container'] = null; //vertical
		} else {
			$this->wrappers['control']['container'] = 'div class="' . $this->formControlContainerWidth . '"'; //horizontal
		}
		if ($this->isFormVerticalOrientation()) {
			$this->wrappers['label']['container'] = null; //vertical
		} else {
			$this->wrappers['label']['container'] = 'div class="' . $this->formControlLabelWidth . ' col-form-label"'; //horizontal
		}
		$this->wrappers['control']['checkbox'] = 'div class="form-check"';
		$this->wrappers['control']['description'] = 'small';
		$this->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';

		if ($this->isFormInline()) {
			$this->form->getElementPrototype()->addClass('form-inline');
		}

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


	public function setFormInline()
	{
		$this->formInline = true;
	}


	/**
	 * Is form in inline
	 * @return bool
	 */
	private function isFormInline(): bool
	{
		return $this->formInline;
	}


	public function setFormControlContainerWidth(string $formControlContainerWidth)
	{
		$this->formControlContainerWidth = $formControlContainerWidth;
	}


	public function setFormControlLabelWidth(string $formControlLabelWidth)
	{
		$this->formControlLabelWidth = $formControlLabelWidth;
	}


	private function generateRadioControls(Nette\Forms\Control $control, ?Html $labelPart): Html
	{
		$fieldset = Html::el('fieldset')->addClass('form-group');
		if ($labelPart != '') {
			$fieldset->addHtml(Html::el('legend')->addHtml($labelPart));
		}

		foreach ($control->items as $key => $labelTitle) {
			$input = $control->getControlPart($key)->addClass('form-check-input'); //input
			$label = $control->getLabelPart($key)->addClass('form-check-label'); //label

			$formCheck = Html::el('div')->addClass('form-check');
			if ($control->getOption('orientation', null) == self::FORM_CHECK_INLINE) {
				$formCheck->class(self::FORM_CHECK_INLINE, true);
			}

			$formCheck->addHtml($input);
			$formCheck->addHtml($label);

			$fieldset->addHtml($formCheck);
		}

		return $fieldset;
	}


	/**
	 * Renders single visual row.
	 */
	public function renderPair(Nette\Forms\Control $control): string
	{
		if (
			$control->getOption('type') === 'radio'
			&& $control->getOption('orientation', null) == self::FORM_CHECK_INLINE
		) {
			$radios = Html::el(null);

			$pair = $this->getWrapper('pair container');

			//title for radio
			if ($this->isFormVerticalOrientation()) {
				//vertical form, one line with title, next line with radios
				$pair->addHtml($this->generateRadioControls($control, $control->getLabelPart()));
			} else {
				//horizontal form, one linew with title and with radios
				$labelContainer = $this->getWrapper('label container')->addHtml($control->getLabelPart());
				$controlContainer = $this->getWrapper('control container');
				$controlContainer->addHtml($this->generateRadioControls($control, null));

				$pair->addHtml($labelContainer);
				$pair->addHtml($controlContainer);
			}

			$radios->addHtml($pair); //add pari with title and radios on one line
			return $radios->render(0);

		} elseif ($control->getOption('type') === 'checkbox') {
			if ($this->isFormVerticalOrientation()) {
				//default vertical orientation
				$pair = Html::el('div')->addClass('form-check');
				if ($control->getOption('orientation', null) == self::FORM_CHECK_INLINE) {
					$pair->class(self::FORM_CHECK_INLINE, true);
				}
			} else {
				//horizontal formular (2 colms)
				if ($control->getOption('orientation', null) == self::FORM_CHECK_INLINE) {
					$pair = $this->getWrapper('pair container');
				} else {
					$pair = $this->getWrapper('pair container');
					//@TODO how to set many checkboxes on same line? problem...
				}
			}

			if ($this->isFormInline()) {
				$pair->class('mb-2 mr-sm-2 mb-sm-0', true);
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
	 * Renders single visual row of multiple controls (SubmitButton).
	 * @param  Nette\Forms\Control[]
	 */
	public function renderPairMulti(array $controls): string
	{
		$s = [];
		foreach ($controls as $control) {
			$description = $control->getOption('description');

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
			$divForControl = Html::el('');
		} else {
			//is horizontal form (2colums)
			$pair = $this->getWrapper('pair container');
			$divForControl = Html::el('div')->addClass('col');
		}

		$pair->addHtml($this->renderLabel($control));
		$pair->addHtml($divForControl->setHtml(implode(' ', $s)));
		return $pair->render(0);
	}


	/**
	 * Renders 'label' part of visual row of controls.
	 */
	public function renderLabel(Nette\Forms\Control $control): Html
	{
		if ($control->getOption('type') === 'button') {
			//none label for label
			return Html::el('');
		} else {
			$suffix = $this->getValue('label suffix') . ($control->isRequired() ? $this->getValue('label requiredsuffix') : '');
			$label = $control->getLabel();

			if ($label instanceof Html) {
				$label->class('form-label', true);
				$label->addHtml($suffix);
				if ($control->isRequired()) {
					$label->class($this->getValue('control .required'), true);
				}
			}

			if ($control->getOption('type') === 'radio' && $this->isFormVerticalOrientation()) {
				//label for radio is in fieldset, not shwo here
				$label = '';
			}

			return $this->getWrapper('label container')->setHtml((string) $label);
		}
	}


	/**
	 * Renders 'control' part of visual row of controls.
	 */
	public function renderControl(Nette\Forms\Control $control): Html
	{
		$body = $this->getWrapper('control container');
		if ($this->counter % 2) {
			$body->class($this->getValue('control .odd'), true);
		}

		$description = $control->getOption('description');
		if ($description != null) { // intentionally ==
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
				$control->getItemLabelPrototype()->addClass('form-check');
				$control->getItemLabelPrototype()->addClass('form-check-label');
			}
			$control->getControlPrototype()->addClass('form-check-input');

			if ($control->getOption('type') == 'checkbox') {
				//checkbox
				if ($this->isFormVerticalOrientation()) {
					$el = Html::el('');
				} else {
					$el = $this->getWrapper('control checkbox');
				}

				if ($control->getOption('orientation', null) == self::FORM_CHECK_INLINE) {
					$el->class(self::FORM_CHECK_INLINE, true);
				}

				$input = $control->getControlPart()->addClass('form-check-input'); //input
				$label = $control->getLabelPart()->addClass('form-check-label'); //label

				$el->addHtml($input);
				$el->addHtml($label);
			} else {
				//radio
				$input = $control->getControlPart();
				$items = $control->getItems();
				$ids = [];
				$values = [];

				if ($control->generateId) {
					foreach ($items as $value => $label) {
						$ids[$value] = $input->id . '-' . $value;
						$values[$value] = $value;
					}
				}
				$elControl = $control->getContainerPrototype()->setHtml(
					Nette\Forms\Helpers::createInputList(
						$control->translate($items),
						array_merge($input->attrs, [
							'id:' => $ids,
							'value:' => $values,
							'checked?' => $control->getValue(),
							'disabled:' => $control->isDisabled(),
							//'data-nette-rules:' => [key($items) => $input->attrs['data-nette-rules']],
						]),
						['for:' => $ids] + $control->getItemLabelPrototype()->attrs,
						//$control->getSeparatorPrototype()
						Html::el('div')
					)
				);

				$el = Html::el('fieldset')->addClass('form-group');
				if ($this->isFormVerticalOrientation()) {
					$el->addHtml(Html::el('legend')->addHtml($control->getLabelPart()));
				}
				$el->addHtml($elControl);
			}

		} else {
			$el = $control->getControl();
		}

		if (
			$control->getOption('type') === 'text'
			|| $control->getOption('type') === 'textarea'
			|| $control->getOption('type') === 'select'
		) {
			$el->class('form-control', true);

			if ($this->isFormInline()) {
				$el->class('mb-2 mr-sm-2 mb-sm-0', true);
			}

		} elseif ($control->getOption('type') === 'file') {
			$el->class('form-control-file', true);
		} else {
			$el->class($this->getValue("control .$el->type"), true);
		}

		return $body->setHtml($el . $description . $this->renderErrors($control));
	}
}
