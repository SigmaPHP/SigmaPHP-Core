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
            strpos(
                file_get_contents('.env'),
                'APP_SECRET_KEY=]D8AvBbt3A!BE*FcW@C0{*-[$=ZcV&y0'
            ) !== false
        );
    }
}
