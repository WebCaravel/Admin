<?php

namespace WebCaravel\Admin\Helper;

class StubHelper
{
    protected string $filePath;
    protected array $data;


    public static function make(string $filePath, array $data = []): static
    {
        $obj = new static();
        $obj->filePath = $filePath;
        $obj->data = $data;

        return $obj;
    }


    public function render(): string
    {
        $code = file_get_contents($this->filePath);

        foreach ($this->data as $key => $val) {
            $code = str_replace('{{ '.$key.' }}', $val, $code);
        }

        return $code;
    }


    public function save($path, $filename = null): self
    {
        $code = $this->render();
        if (! $filename) {
            $filename = substr(basename($this->filePath), 0, -5);
        }
        file_put_contents($path.$filename, $code);

        return $this;
    }
}
