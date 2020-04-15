<?php

namespace App\ViewModels;

use App\Core\IBindable;
use App\Core\Validator;

class CreateTaskRequest implements IBindable
{
    public string $username = "";
    public string $email = "";
    public string $description = "";
    public bool $status = false;

    private array $validation_errors;

    function bind(array $array) : bool
    {
        if (Validator::IsStringWithoutSpaces($array['username']))
            $this->username = $array['username'];
        else
            $this->validation_errors['username'] = "User Name is invalid";

        if (Validator::isEmail($array['email']))
            $this->email = $array['email'];
        else
            $this->validation_errors['email'] = "Email is invalid";

        if (Validator::isString($array['description']))
            $this->description = htmlentities($array['description']);
        else
            $this->validation_errors['description'] = "Description is invalid";

        if (Validator::isBool($array['status']))
            $this->status = $array['status'];
        else
            $this->validation_errors['status'] = "Status is invalid";

        return empty($this->validation_errors);
    }

    function errors(): array
    {
        return isset($this->validation_errors) ? $this->validation_errors : [];
    }
}