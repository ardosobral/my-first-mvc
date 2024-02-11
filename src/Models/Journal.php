<?php

namespace App\Models;

class Journal
{
    public function __construct(
        public $name,
        public $publishedYear
    ) {
        
    }
}
