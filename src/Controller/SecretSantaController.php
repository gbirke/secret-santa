<?php
namespace App\Controller;

use App\Entity\Donor;
use Doctrine\ORM\NoResultException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecretSantaController extends AbstractController
{
    public function index()
    {
    	$repo = $this->getDoctrine()->getRepository( Donor::class );
        $donors = $repo->findAll();

        return $this->render( 'secret-santa/index.html.twig', [
        	'donors' => $donors,
			'submissions' => $repo->countSubmissions()
		]);
    }

    public function prepareSubmission(string $accessCode) {
		$repo = $this->getDoctrine()->getRepository( Donor::class );
		try {
			$donor = $repo->findOneByAccessCode( $accessCode );
		} catch( NoResultException $e ) {
    		return new Response( 'Account nicht gefunden', Response::HTTP_UNAUTHORIZED );
		}
		if ( $donor->hasSubmitted() ) {
			return $this->redirectToRoute( 'index' );
		}
		return $this->render( 'secret-santa/submit.html.twig', [
			'donor' => $donor,
			'receivers' => $repo->getReceiversForDonor( $donor )
		] );
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
