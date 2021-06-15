<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private const EPISODE_NB = 5;

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i <= self::EPISODE_NB; $i++) {
        $episode = new Episode();
        $episode->setSeason($this->getReference('season_' .
            rand(0,SeasonFixtures::SEASON_NB)));
        $episode->setTitle('Title ' .$i);
        $episode->setNumber($i);
        $manager->persist($episode);
        $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class,
        ];
    }
}