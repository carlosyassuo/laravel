<?php

namespace CarlosYassuo\Laravel\Controllers;

use Illuminate\Http\Request;
use CarlosYassuo\Laravel\Inspire;

class InspirationController
{
    public function __invoke(Inspire $inspire) {
        $quote = $inspire->justDoIt();

        return $quote;
    }
}
