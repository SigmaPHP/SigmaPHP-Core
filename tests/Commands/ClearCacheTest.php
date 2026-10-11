<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\ClearCache;

/**
 * Clear Cache Command Test
 */
class ClearCacheTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        if (file_exists('cache/')) {
            file_put_contents(
                'cache/file101',
                'test'
            );
        }

        $command = $this->commandFactory(ClearCache::class);

        $command->execute();

        $this->assertTrue(empty(glob('cache/*')));
    }
}
