<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-11
 * Time: 23:25
 */
namespace AppBundle\Utils\Manager;

interface IFilterQuery
{
    public function prepareStatusFilterQuery($td, $forms);

    public function prepareDataFilterQuery($td, $forms);

    public function prepareKlientFilterQuery($td, $forms);
}