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
    public function prepareStatusFilterQuery(TableDetails $td, FormsManagerExtended $forms);

    public function prepareDataFilterQuery(TableDetails $td, FormsManagerExtended $forms);

    public function prepareKlientFilterQuery(TableDetails $td,FormsManagerExtended $forms);
}