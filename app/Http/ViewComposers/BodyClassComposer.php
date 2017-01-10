<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Auth;
use Gate;

class BodyClassComposer
{

    /**
     * Create a body class composer.
     *
     * @return void
     */
    public function __construct()
    {

        $body_classes = [];

        if (Auth::check()) {
            $body_classes[] = 'logged-in';
        } else {
            $body_classes[] = 'not-logged-in';
        }

        if (session()->has('errors')) {
            $body_classes[] = 'has-errors';
        }

        $body_class = implode(' ', $body_classes);
        $this->body_class = $body_class;

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['body_class' => $this->body_class]);
    }
}
