<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert1 extends Component
{
	public $creating;
	public $icon;
	public $title;
	public $text;
	public $boton1;
	public $accion;
	public $boton2;

    public function __construct($creating, $icon, $title, $text, $boton1,$accion, $boton2)
    {
		$this->creating = $creating;
		$this->icon = $icon;
		$this->title = $title;
		$this->text = $text;
		$this->boton1 = $boton1;
		$this->accion = $accion;
		$this->boton2 = $boton2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert1');
    }
}
