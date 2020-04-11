<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 */
class EmailTest extends TestCase
{
    private Client $mailcatcher;
    private bool $isSuccessfullySent;

    protected function setUp(): void
    {
        $this->mailcatcher = new Client(['base_uri' => 'http://smtp:1080', 'timeout' => 10]);
        $this->cleanMessages();
        $this->isSuccessfullySent = $this->sendMessage();
    }

    public function testNotificationIsSent(): void
    {
        $email = $this->getLastMessage();
        $this->assertEmailIsSent($this->isSuccessfullySent);
        $this->assertEmailSenderEquals($this->composeMessage()['from'], $email);
        $this->assertEmailRecipientsContain($this->composeMessage()['to'], $email);
        $this->assertEmailSubjectEquals($this->composeMessage()['subject'], $email);
    }

    private function getLastMessage()
    {
        $messages = $this->getMessages();
        if (empty($messages)) {
            $this->fail('No messages received');
        }

        return reset($messages);
    }

    private function getMessages()
    {
        $jsonResponse = $this->mailcatcher->request('GET', '/messages');

        return json_decode($jsonResponse->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function assertEmailIsSent($result): void
    {
        $this->assertTrue($result);
    }

    public function assertEmailSenderEquals($from, $email): void
    {
        $expected = '<'.$from.'>';
        $this->assertEquals($expected, $email['sender']);
    }

    public function assertEmailRecipientsContain($to, $email): void
    {
        $needle = '<'.$to.'>';
        $this->assertContains($needle, $email['recipients']);
    }

    public function assertEmailSubjectEquals($expected, $email): void
    {
        $this->assertEquals($expected, $email['subject']);
    }

    private function cleanMessages(): void
    {
        $this->mailcatcher->request('DELETE', '/messages');
    }

    private function sendMessage(): bool
    {
        return mail(
            $this->composeMessage()['to'],
            $this->composeMessage()['subject'],
            $this->composeMessage()['message'],
            $this->composeMessage()['headers']
        );
    }

    private function composeMessage(): array
    {
        $from = 'admin@tommynovember7.dev';

        return [
            'from'    => $from,
            'to'      => 'tomo@tn7.tokyo',
            'subject' => 'PHP Mail Test script',
            'message' => 'This is a test to check the PHP Mail functionality',
            'headers' => "From: $from",
        ];
    }
}