<?php

namespace App\Http\ViewComposers;

use Request;
use Illuminate\View\View;

class AdminMenuComposer
{

    /**
     * Create a body class composer.
     *
     * @return void
     */
    public function __construct()
    {

        // Passes the section variable to the view
        $url_segments = Request::segments();
        $current_section = isset($url_segments[1]) ? $url_segments[1] : null;
        $third_segment = isset($url_segments[2]) ? $url_segments[2] : null;
        $fourth_segment = isset($url_segments[3]) ? $url_segments[3] : null;
        $sections = ['product', 'post', 'page', 'asset', 'user', 'settings'];

        if (is_null($current_section)) {

            // The url is admin root path (/admin)
            $this->current_section = [
                'parent' => 'dashboard'
            ];

        } else {

            if (in_array($current_section, $sections)) {

                // Passes the current section name and the url segments to the view
                $this->current_section = [
                    'parent' => $current_section,
                    'child' => $third_segment
                ];

            } else {

                // Sections that don't have children
                $this->current_section = [
                    'parent' => null
                ];

            }

        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['current_section' => $this->current_section]);
    }
}
