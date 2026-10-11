<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateCommand;

/**
 * Create 'Custom Command' Command Test
 */
class CreateCommandTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'commands/FormatCommand.php';

        $command = $this->commandFactory(CreateCommand::class);

        $command->getArguments()['name']->setValue('Format');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}
