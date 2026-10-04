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

        $command = new _CreateSecret();

        $command->setIOHandler($this->ioHandler);

        $command->execute();

        $this->assertTrue(
            strpos(
                file_get_contents('.env'),
                'APP_SECRET_KEY=]D8AvBbt3A!BE*FcW@C0{*-[$=ZcV&y0'
            ) !== false
        );
    }
}

class _CreateSecret extends CreateSecret
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
