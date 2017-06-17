<?php

namespace App\Core;

class MultiException extends \Exception implements \ArrayAccess, \Iterator
{

    use TCollection;

}
