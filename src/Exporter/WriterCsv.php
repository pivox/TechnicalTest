<?php


namespace App\Exporter;


/**
 * Class WriterCsv
 * @package App\Exporter
 */
class WriterCsv implements WriterInterface
{
    /** @var string */
    private $path;

    /** @var string */
    private $name;

    /**
     * WriterCsv constructor.
     * @param string $path
     * @param string $name
     */
    public function __construct(string $path, string $name)
    {
        $this->path = $path;
        $this->name = $name;
    }


    /**
     * @param array $data
     */
    public function write(array $data)
    {
        $fullPath = $this->path.'/'.$this->name;
        $handle = fopen($fullPath, 'w+');
        foreach ($data as $subArray) {
            $line = implode(",", $subArray)."\n";
            file_put_contents($fullPath, $line, FILE_APPEND);
        }
        fclose($handle);
    }
}