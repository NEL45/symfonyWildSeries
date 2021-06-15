<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASON_NB = 5;

    public function load(ObjectManager $manager)
    {
        for ($i =0; $i < self::SEASON_NB; $i++){
           $season = new Season();
           $season->setProgram($this->getReference('program_2'));
           $season->setNumber($i);
           $season->setYear(2020+$i);
           $season->setDescription('Description of season ' .$i);
           $manager->persist($season);
           $this->addReference('season_' . $i, $season);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [ProgramFixtures::class,
        ];
    }
}