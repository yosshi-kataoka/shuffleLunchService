<?php

namespace ShuffleLunch;

function escape(string $string): string
{
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
