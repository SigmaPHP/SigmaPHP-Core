<?php

namespace SigmaPHP\Core\Http;

use SigmaPHP\Core\Exceptions\FileNotFoundException;
use SigmaPHP\Core\Exceptions\InvalidArgumentException;
use SigmaPHP\Core\Interfaces\Http\FileInterface;
use SigmaPHP\Filesystem\Filesystem;

/**
 * File Class
 */
class File implements FileInterface
{
    /**
     * @var string $storagePath
     */
    private $storagePath;

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * File Constructor
     *
     * @param string $storagePath
     */
    public function __construct($storagePath)
    {
        $this->filesystem = new Filesystem();

        $this->storagePath = root_path($storagePath);

        if (!$this->filesystem->exists($this->storagePath)) {
            throw new InvalidArgumentException(
                "Storage path {$this->storagePath} doesn't exists"
            );
        }
    }

    /**
     * Save file to storage.
     *
     * @param array $fileData
     * @return bool
     */
    public function save($fileData)
    {
        if (!is_array($fileData)) {
            throw new InvalidArgumentException(
                "Invalid file upload was provided !"
            );
        }

        if (!isset($fileData["tmp_name"]) ||
            !$this->filesystem->exists($fileData["tmp_name"])
        ) {
            throw new FileNotFoundException(
                "The file you are trying to upload is invalid or doesn't exist"
            );
        }

        return $this->filesystem->rename(
            $fileData["tmp_name"],
            $this->storagePath . '/' . $fileData["name"]
        );
    }

    /**
     * Check if file exists in the storage.
     *
     * @param string $fileName
     * @return bool
     */
    public function has($fileName)
    {
        return $this->filesystem->exists(
            $this->storagePath . '/' . ltrim($fileName, '/')
        );
    }

    /**
     * Retrieve file's content from storage.
     *
     * @param string $fileName
     * @return mixed
     */
    public function get($fileName)
    {
        $fileFullPath = $this->storagePath . '/' . ltrim($fileName, '/');

        if (!$this->filesystem->exists($fileFullPath)) {
            throw new FileNotFoundException("File {$fileName} doesn't exist");
        }

        return $this->filesystem->read($fileFullPath);
    }
}
