<?php

declare(strict_types=1);

namespace App;

class DonorToReceiverResolver
{
	const MAX_ASSIGNMENT_TRY_PROBABILITY = 0.0000001;

	public static function resolve( array $donorIds, array $receiverIds,
									float $collisionProbabilityForRetries = self::MAX_ASSIGNMENT_TRY_PROBABILITY ): array {
		$donorCount = count($donorIds);
		if ( $donorCount === 0 ) {
			throw new \InvalidArgumentException( 'Donor count must be at least 1' );
		}
		if ( $donorCount !== count( $receiverIds ) ) {
			throw new \InvalidArgumentException( 'Donor and Receiver lenghts must be the same' );
		}

		// degenerate case
		if ( $donorCount === 1 ) {
			if ( $donorIds[0] === $receiverIds[0] ) {
				throw new \InvalidArgumentException( 'Donor and Receiver id must be different' );
			} else {
				return [ $donorIds[0] => $receiverIds[0] ];
			}
		}

		// Probability of picking the identical id is 1/$donorCount for 1st try, 1/$donorCount^2 for 2nd try, etc
		// To get the number of tries where the probability is below $collisionProbabilityForRetries,
		// we need solve the following equation for $numTries:
		// $collisionProbabilityForRetries = 1 / ( $donorCount ^ $numTries )
		$maxTries = ceil( log( 1 / $collisionProbabilityForRetries ) / log( $donorCount ) ) + 1; // Adding +1 to be extra sure
		for ($i = 0; $i < $maxTries; $i++ ) {
			shuffle( $receiverIds );
			$assignments = array_combine( $donorIds, $receiverIds );
			if ( !self::hasSelfAssignments( $assignments ) ) {
				return $assignments;
			}
		}
		throw new \RuntimeException( sprintf('Could not assign unique pairs after %d tries', $maxTries ) );
	}

	private static function hasSelfAssignments( array $assignments ): bool {
		return count(
			array_filter(
				$assignments,
				function ( $key, $value ) { return $key === $value; },
				ARRAY_FILTER_USE_BOTH
			)
		) > 0;
	}
}
