<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Predis\Client;

/**
 * Class RedisConnectionTest
 */
class RedisConnectionTest extends TestCase
{
    private const TEST_KEY = 'foo';
    private const TEST_VALUE = 'Cowabunga';

    public function testSetAndGet(): void
    {
        $client = $this->createClient();
        $client->set(self::TEST_KEY, self::TEST_VALUE);

        $this->assertEquals(self::TEST_VALUE, $client->get(self::TEST_KEY));
    }

    private function createClient(): Client
    {
        return new Predis\Client(
            [
                'host'     => 'redis',
                'port'     => 6379,
                'password' => null,
            ]
        );
    }
}