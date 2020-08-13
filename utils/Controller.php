<?php
namespace Utils;

class Controller
{
    protected $message = "";
    protected $output = [];

    /**
     * output
     *
     * @return array
     */
    public function output(): array
    {
        return $this->output;
    }

    /**
     * message
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
