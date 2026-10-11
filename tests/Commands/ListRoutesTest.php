<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\ListRoutes;

/**
 * List Routes Command Test
 */
class ListRoutesTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $command = $this->commandFactory(ListRoutes::class);

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command->execute();

        $this->expectOutputString(
            file_get_contents(__DIR__ . '/list_routes.output'),
        );
    }
}
