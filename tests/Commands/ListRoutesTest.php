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
        $command = new _ListRoutes();

        $command->setIOHandler($this->ioHandler);

        $command->execute();

        $this->expectOutputString(
            file_get_contents(__DIR__ . '/list_routes.output'),
        );
    }
}

class _ListRoutes extends ListRoutes
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
