<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PhoneNumber extends Constraint
{
    public $message = 'Wyrażenie "%string%" zawiera niedozwolone znaki.';
}

