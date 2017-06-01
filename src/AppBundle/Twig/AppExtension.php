<?php

// używane w \src\AppBundle\Resources\views\Book\show_books_by.html.twig

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('ucwords', array($this, 'ucwordsFilter')),
        );
    }

    public function ucwordsFilter($value) {
        $sentence=ucwords($value);

        return $sentence;
    }

    public function getName() {
        return 'app_extension';
    }

}
