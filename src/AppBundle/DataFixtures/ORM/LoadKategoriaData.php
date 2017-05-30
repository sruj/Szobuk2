<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class LoadData implements FixtureInterface {

    function load(ObjectManager $manager) {
        $data = file('data/kategorie.txt');
        foreach ($data as $i) {
            $Name = new Category();
            $Name->setNazwa(trim($i));
            $manager->persist($Name);
        }
        $manager->flush();
    }

}
