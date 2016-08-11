<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PlikRozszerzeniem extends Constraint
{
    public $message = 'Wyrażenie "%string%" zawiera niedozwolone znaki. Powinno zawierać nazwę pliku wraz z kropką i rozszerzeniem pliku';
}

