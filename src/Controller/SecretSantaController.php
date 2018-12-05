<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecretSantaController extends AbstractController
{
    public function index()
    {
    	// TODO Read from DB
        $people = [];

        // TODO Read from DB
		$submissions = [];

        return $this->render( 'secret-santa/index.html.twig', [
        	'peope' => $people,
			'submissions' => $submissions
		]);
    }
}
