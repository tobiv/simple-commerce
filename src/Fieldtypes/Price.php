<?php

namespace Damcclean\Commerce\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Price extends Fieldtype
{
    public function defaultValue()
    {
        return null;
    }

    public function preProcess($data)
    {
        return $data;
    }

    public function process($data)
    {
        return $data;
    }
}
