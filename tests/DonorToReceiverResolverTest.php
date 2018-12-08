<?php

declare(strict_types=1);

namespace App\Tests;

use App\DonorToReceiverResolver;
use PHPUnit\Framework\TestCase;

class DonorToReceiverResolverTest extends TestCase
{
    public function test_given_one_donor_and_a_different_receiver_then_they_are_paired()
    {
    	$donorIds = [ 1 ];
		$receiverIds = [ 2 ];
		$result = DonorToReceiverResolver::resolve( $donorIds, $receiverIds );
		$this->assertEquals( [ 1 => 2 ], $result );
    }

	public function test_given_two_donors_and_receivers_then_they_are_paired_cross_wise()
	{
		$donorIds = [ 1, 2 ];
		$receiverIds = [ 1, 2 ];
		$result = DonorToReceiverResolver::resolve( $donorIds, $receiverIds );
		$this->assertEquals( [ 1 => 2, 2 => 1 ], $result );
	}

	public function test_given_equal_ids_then_exception_is_thrown()
	{
		$donorIds = [ 1 ];
		$receiverIds = [ 1 ];
		$this->expectException( \InvalidArgumentException::class );
		DonorToReceiverResolver::resolve( $donorIds, $receiverIds );
	}

	public function test_given_empty_ids_then_exception_is_thrown()
	{
		$donorIds = [];
		$receiverIds = [];
		$this->expectException( \InvalidArgumentException::class );
		DonorToReceiverResolver::resolve( $donorIds, $receiverIds );
	}

	public function test_given_unequal_id_count_then_exception_is_thrown()
	{
		$donorIds = [ 1, 2 ];
		$receiverIds = [ 1 ];
		$this->expectException( \InvalidArgumentException::class );
		DonorToReceiverResolver::resolve( $donorIds, $receiverIds );
	}

	/**
	 * A clumsy test for getting 100% coverage.
	 * The probability for the test to fail is 1/10^31 (almost zero)
	 * See https://stackoverflow.com/questions/641318/test-probabilistic-functions
	 */
	public function test_given_high_collision_probability_then_runtime_exceptions_can_occur()
	{
		$donorIds = [ 1, 2 ];
		$receiverIds = [ 1, 2 ];
		$this->expectException( \RuntimeException::class );
		for ( $i = 0; $i < pow( 10, 30 ); $i++ ) {
			DonorToReceiverResolver::resolve( $donorIds, $receiverIds, 1.0 );
		}
	}
}
