<?php
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
        	'people' => $people,
			'submissions' => $submissions
		]);
    }

    public function storeSubmission() {
    	//TODO
		// Store donor id and receiver status (known/unknown) in submissions table in DB
		// if gift status is known, store receiver in known_receivers table in DB
		// if submissions length === people length, go to pick route, otherwise display success page
	}

	public function pickReceivers() {
    	// TODO
		// $donors = people - submissions where receiver is known
		// $receivers = $people - known_receivers
		// match $donors randomly to $receivers, making sure that donor[$i] !== $receiver[$i]
		// send mail to each donor
	}
}
