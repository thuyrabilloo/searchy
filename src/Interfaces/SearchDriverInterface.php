<?php

namespace Rabiloo\Searchy\Interfaces;

interface SearchDriverInterface
{
    public function query($searchString);

    public function select(/* $columns */);

    public function get();
}
