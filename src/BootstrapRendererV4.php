<?php

declare(strict_types=1);

namespace VencaX\NetteFormRenderer;

use Nette;

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
		$this->wrappers['control']['description'] = 'small';
		$this->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
		$this->wrappers['control']['.text'] = $this->wrappers['control']['.text'] . ' form-control';
		$this->wrappers['control']['.password'] = $this->wrappers['control']['.password'] . ' form-control';
		$this->wrappers['control']['.file'] = $this->wrappers['control']['.file'] . ' form-control';
		$this->wrappers['control']['.email'] = $this->wrappers['control']['.email'] . ' form-control';
		$this->wrappers['control']['.number'] = $this->wrappers['control']['.number'] . ' form-control';

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
}
