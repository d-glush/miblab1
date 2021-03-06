<?php

class Response
{
    private array $data;
    private int $code;

    public function __construct(array $data, int $code)
    {
        $this->data = $data;
        $this->code = $code;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function display(): void
    {
        echo json_encode(['data' => $this->data, 'code' => $this->code]);
    }
}