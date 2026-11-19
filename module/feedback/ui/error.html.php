<?php
namespace zin;
div(
    setClass('panel p-4'),
    p(setClass('text-danger'), $error),
    a(set::href(helper::createLink('feedback', 'browse')), $lang->feedback->back)
);
