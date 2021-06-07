<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use App\Entity\Season;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */

    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'programs/index.html.twig',
            ['programs' => $programs]
        );
    }

/**
 * Getting a program by id
 *
 * @Route("/show/{id<^[0-9]+$>}", name="show")
 * @return Response
 */

    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {
        if (!$program) {

            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );

        }

        $seasons = $seasonRepository->findAll();

        return $this->render('programs/show.html.twig', [
            'program' => $program,'seasons' => $seasons
        ]);
    }


    /**
    * @Route("/{program}/seasons/{season}", name="season_show")
    * @return Response
    */

    public function showSeason(Program $program, Season $season){

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findAll();

        return $this->render(
            'programs/season_show.html.twig',
            ['program' => $program, 'season' => $season, 'episodes' => $episodes]
        );

    }

    /**
    * @Route("/{programId}/seasons/{seasonId}/episodes/{episodeId}", name="episode_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
    * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
    * @return Response
    */

    public function showEpisode(Program $program, Season $season, Episode $episode){

        return $this->render(
            'programs/season_show.html.twig',
            ['program' => $program, 'season' => $season, 'episodes' => $episode]
        );

    }


}