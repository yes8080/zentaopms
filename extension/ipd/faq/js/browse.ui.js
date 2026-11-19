window.toggleFaqToc = function()
{
    var $toc = $('#faqToc');
    if(!$toc.length) return;

    $toc.toggleClass('hidden');
    $('#toggleTocText').text($toc.hasClass('hidden') ? faqShow : faqHidden);
};
