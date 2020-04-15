<?php

namespace App\ViewModels;

use App\Core\IBindable;
use App\Core\Validator;

class EditTaskRequest implements IBindable
{
    public int $id;
    public string $description;
    public bool $status;

    private array $validation_errors = [];

    public function bind(array $array) : bool
    {
        if (Validator::isInt($array['id']))
            $this->id = intval($array['id']);
        else
            $this->validation_errors['id'] = "Id is invalid";

        if (Validator::isString($array['description']))
            $this->description = htmlentities($array['description']);
        else
            $this->validation_errors['description'] = "Description is invalid";

        if (Validator::IsBool($array['status']))
            $this->status = filter_var($array['status'], FILTER_VALIDATE_BOOLEAN);
        else
            $this->validation_errors['status'] = "Status is invalid";

        return empty($this->validation_errors);
    }

    function errors(): array
    {
        return $this->validation_errors;
    }
}