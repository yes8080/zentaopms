<?php
namespace zin;

return static function(string $name, string $value, bool $rich): string
{
    if(!$rich) $value = nl2br(htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    disableGlobalRender();
    try
    {
        return editor(set::name($name), set::value($value), set::mentions(false), set::placeholder(' '), set::uploadUrl(''))->render();
    }
    finally
    {
        enableGlobalRender();
    }
};
