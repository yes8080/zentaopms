window.reasonChange = function()
{
    const reason = $('[name=closedReason]').val();
    $('.repeatFeedbackBox').closest('.form-row').toggleClass('hidden', reason !== 'repeat');
}
