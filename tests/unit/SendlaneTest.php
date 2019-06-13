<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Rewake\Sendlane\SendlaneClient;

class SendlaneTest extends TestCase
{
    /**
     * @test
     * @testdox Can load config json file
     */
    public function can_instantiate_class()
    {
        // Instantiate Sendlane class
        $sl = new SendlaneClient();

        // Assert that we have a Sendlane instance
        $this->assertInstanceOf(SendlaneClient::class, $sl);

        // Pass class on the next test
        return $sl;
    }

    /**
     * @test
     * @depends can_instantiate_class
     * @doesNotPerformAssertions
     * @testdox Can configure class using configure() method
     */
    public function can_configure_class($sl)
    {
        $sl->configure('test', 'test', 'test');

        // TODO: make sure config was stores as expected
    }

    /**
     * @test
     * @testdox Can instantiate and configure class
     */
    public function can_instantiate_class_with_config_vals()
    {
        // Instantiate Sendlane class
        $sl = new SendlaneClient('test', 'test', 'test');

        // Assert that we have a Sendlane instance
        $this->assertInstanceOf(SendlaneClient::class, $sl);

        // TODO: make sure config was stores as expected
    }
}