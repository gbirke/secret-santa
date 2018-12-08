<?php
namespace App\Controller;

use App\Entity\Donor;
use App\Entity\Receiver;
use Doctrine\ORM\NoResultException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
		return $this->render( 'secret-santa/prepare_submit.html.twig', [
			'donor' => $donor,
			'receivers' => $repo->getReceiversForDonor( $donor )
		] );
	}

    public function storeSubmission( Request $request ) {
    	$donorId = $request->request->getInt( 'donor' );
    	$receiverId = $request->request->getInt( 'receiver' );

    	$repo = $this->getDoctrine()->getRepository( Donor::class );
    	$manager = $this->getDoctrine()->getManager();

    	$donor = $repo->find( $donorId );
    	if ( $donor === null ) {
    		return new Response( 'Schenkender nicht gefunden - bitte Gabriel fragen, was schief gelaufen ist.', Response::HTTP_BAD_REQUEST );
		}

		$donor->setSubmitted( true );

		$receiver = $repo->find( $receiverId );
		if ( $receiverId > 0 && $receiver !== null ) {
			$donor->setKnowsReceiver( true );
			$knownReceiver = new Receiver();
			$knownReceiver->setDonor( $receiver );
			$manager->persist( $knownReceiver );
		}

		$manager->persist( $donor );
		$manager->flush();

		$missingSubmissions = $repo->countMissingSubmissions();
		if ( $missingSubmissions > 0 ) {
			return $this->render( 'secret-santa/submit.html.twig', [
				'missingSubmissions' => $missingSubmissions,
				'donor' => $donor
			] );
		}

		$this->pickReceivers();

		return $this->render( 'secret-santa/success.html.twig', [
			'donor' => $donor
		] );
	}

	private function pickReceivers() {
    	// TODO
		// $donors = people - submissions where receiver is known
		// $receivers = $people - known_receivers
		// match $donors randomly to $receivers, making sure that donor[$i] !== $receiver[$i]
		// send mail to each donor
	}
}
