<?php

namespace App\DataFixtures;


use App\Entity\Posts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $post = new Posts();
        $post->setName('Why Asteroids Taste Like Bacon');
        $post->setPublished(true);
        $post -> setContent('In this post we\'ll explore the reasons why asteroids taste like bacon, a secret that has kept many scientists wondering for decades.');
        $post -> setSlug('why-asteroids-taste-like-bacon');
        $post -> setDescription('Astronomers and astronauts reveal the truth behind the bacon-like taste of asteroids.');
        $post -> setUpdatedAt(new \DateTime('2020-03-18 10:00:00'));
        $post -> setCreatedAt(new \DateTime('2020-03-18 10:00:00'));

        $manager->persist($post);
        $manager->flush();


    }
}
