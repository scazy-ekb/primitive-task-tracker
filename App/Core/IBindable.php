<?php

namespace App\Core;

interface IBindable
{
    function bind(array $array);
    function errors() : array;
}