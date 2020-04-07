<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class MysqliConnectionTest extends TestCase
{
    private const FIXTURE = 'sql/fixture.sql';
    private const TEMPLATE = 'mysql --host=mysql --user=root --default-character-set=utf8mb4 < %s';
    private const SQL = 'SELECT * FROM user WHERE id = 2';

    protected function setUp(): void
    {
        if (!file_exists(self::FIXTURE)) {
            throw new RuntimeException('Fixture not found.');
        }
        $command = sprintf(self::TEMPLATE, self::FIXTURE);
        shell_exec($command);
    }

    public function testConnection(): void
    {
        /** @var mysqli $client */
        $client = $this->createClient();
        $result = $client->query(self::SQL);
        $this->assertInstanceOf( 'mysqli_result', $result);
        $rows = $result->fetch_all();
        $this->assertEquals('jonny', $rows[0][1]);
    }

    private function createClient(): mysqli
    {
        $client = new mysqli('mysql', 'root', '', 'connection_test');
        if ($client->connect_errno) {
            throw new RuntimeException('Error: Failed to make a MySQL connection');
        }

        return $client;
    }
}