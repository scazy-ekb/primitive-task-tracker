<?php

namespace App\ViewModels;

use App\Core\IBindable;
use App\Core\Validator;

class PageRequest implements IBindable
{
    public int $page = 0;
    public int $count = 10;
    public string $column = 'id';
    public bool $order = true;

    private array $validation_errors = array();

    function bind(array $array)
    {
        if (Validator::isNotNegativeInt($array['page']))
            $this->page = intval($array['page']);
        else
            $this->validation_errors['page'] = 'Page is invalid.';

        if (Validator::isPositiveInt($array['count']))
            $this->count = intval($array['count']);
        else
            $this->validation_errors['count'] = 'Count is invalid.';

        if (Validator::isStringWithoutSpaces($array['column']))
            $this->column = $array['column'];
        else
            $this->validation_errors['column'] = 'Column is invalid.';

        if (Validator::isBool($array['order']))
            $this->order = boolval($array['order']);
        else
            $this->validation_errors['order'] = 'Order is invalid.';
    }

    function errors(): array
    {
        return $this->validation_errors;
    }
}