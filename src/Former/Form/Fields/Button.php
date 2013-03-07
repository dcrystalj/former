<?php
namespace Former\Form\Fields;

use Form;
use Former\Helpers;
use Former\Traits\Field;

/**
 * Button fields
 */
class Button extends Field
{
  /**
   * The Illuminate Container
   *
   * @var Container
   */
  protected $app;

  ////////////////////////////////////////////////////////////////////
  /////////////////////////// CORE METHODS ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Easier arguments order for button fields
   *
   * @param Container $app        The Illuminate Container
   * @param string    $type       button/submit/reset/etc
   * @param string    $value      The text of the button
   * @param string    $link       Its link
   * @param array     $attributes Its attributes
   */
  public function __construct($app, $type, $value, $link, $attributes)
  {
    $this->app        = $app;
    $this->attributes = (array) $attributes;
    $this->type       = $type;
    $this->value($value);

    // Add href to attributes if link
    if ($this->type == 'link') {
      $this->link = $link;
    }
  }

  /**
   * Renders the button
   *
   * @return string A form button
   */
  public function render()
  {
    $type = $this->type;
    $this->attributes['name'] = $this->name;

    // Link buttons
    if ($type == 'link') {
      return $this->app['meido.html']->to($this->link, $this->value, $this->attributes);
    }

    return $this->app['meido.form']->$type($this->value, $this->attributes);
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////// FIELD METHODS ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Check if the field is a button
   *
   * @return boolean
   */
  public function isButton()
  {
    return true;
  }

  /**
   * Hijack Former's Object model value method
   *
   * @param  string $value The new button text
   */
  public function value($value)
  {
    $value = Helpers::translate($value);

    $this->value = $value;

    return $this;
  }
}
