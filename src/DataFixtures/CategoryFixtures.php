<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file_content = file_get_contents(__DIR__.'/data/Category.json');
        $data = json_decode($file_content, true);
        CategoryFactory::createSequence($data);
        CategoryFactory::createOne();
    }
}
