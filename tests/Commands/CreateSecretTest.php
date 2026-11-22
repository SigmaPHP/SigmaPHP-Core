<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateSecret;

/**
 * Create Secret Command Test
 */
class CreateSecretTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        // disable randomness
        mt_srand(1);

        $command = $this->commandFactory(CreateSecret::class);

        $command->execute();

        $this->assertTrue(
            preg_match(
                '/APP_SECRET_KEY=.{32}/',
                file_get_contents('.env'),
            ) !== false
        );
    }
}
