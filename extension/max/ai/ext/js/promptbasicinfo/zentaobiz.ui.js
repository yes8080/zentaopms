window.promptBasicNameChanged = false;
window.promptBasicAutoName = '';

window.changeProcessObject = function(module)
{
    const picker = zui.Picker.query("[name='actionPurpose']");
    if(!picker) return;

    const items = [{text: '', value: ''}].concat(actionPurposeItemsByModule[module] || []);
    picker.render({items: items});
    picker.$.clear();
    window.changeActionPurpose('');
};

window.changeActionPurpose = function(actionPurpose)
{
    window.changeDisplayPosition(actionPurpose);

    if(window.promptBasicNameChanged) return;

    const nameInput = document.querySelector("[name='name']");
    if(!nameInput) return;

    const currentName = nameInput.value || '';
    if(currentName !== '' && currentName !== window.promptBasicAutoName)
    {
        window.promptBasicNameChanged = true;
        return;
    }

    const name = actionPurposeNameMap[actionPurpose] || '';
    nameInput.value = name;
    window.promptBasicAutoName = name;
};

function escapeDisplayPositionHTML(value)
{
    return String(value || '').replace(/[&<>"']/g, function(char)
    {
        return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[char];
    });
}

function buildDisplayPositionItem(position)
{
    const label     = displayPositionList[position] || '';
    const descList  = typeof displayPositionDescList === 'undefined' ? {} : displayPositionDescList;
    const imageList = typeof displayPositionImageList === 'undefined' ? {} : displayPositionImageList;
    const desc      = descList[position] || '';
    const image     = imageList[position] || '';
    const imageHtml = image ? '<img src="' + escapeDisplayPositionHTML(image) + '" alt="' + escapeDisplayPositionHTML(label) + '" />' : '';
    const html      = '<div class="display-position-preview">' + imageHtml + '</div><div class="display-position-info"><div class="display-position-title">' + escapeDisplayPositionHTML(label) + '</div><div class="display-position-desc">' + escapeDisplayPositionHTML(desc) + '</div></div>';

    return {text: label, value: position, keys: label + ' ' + desc, content: {html: html, class: 'display-position-box flex w-full border no-wrap pl-1 py-4'}};
}

window.changeDisplayPosition = function(actionPurpose)
{
    const picker = zui.Picker.query("[name='displayPosition']");
    if(!picker) return;

    const allowedPositions = displayPositionMap[actionPurpose] || Object.keys(displayPositionList);
    const items = [{text: '', value: ''}].concat(allowedPositions.filter(position => displayPositionList[position]).map(position => buildDisplayPositionItem(position)));
    const input = document.querySelector("[name='displayPosition']");
    const currentValue = input ? input.value : '';

    picker.render({items: items});
    if(currentValue && allowedPositions.includes(currentValue)) picker.$.setValue(currentValue);
    if(currentValue && !allowedPositions.includes(currentValue)) picker.$.clear();
    window.changePromptDisplayPosition(input ? input.value : '');
};

window.changePromptDisplayPosition = function(displayPosition)
{
    const inputFieldsStep = document.querySelector(".nav-steps [data-step='setinputfields']");
    const inputFieldsLink = document.querySelector(".nav-steps [data-step='setinputfields'] a");
    const inputFormStep = document.querySelector(".nav-steps [data-step='setinputform'] a");
    if(!inputFieldsStep || !inputFieldsLink || !inputFormStep) return;

    inputFieldsStep.classList.toggle('hidden', displayPosition === 'form');
    inputFieldsLink.classList.toggle('disabled', displayPosition === 'form');
    inputFormStep.classList.toggle('disabled', displayPosition !== 'form');
};

window.changePromptBasicName = function(event)
{
    window.promptBasicNameChanged = event.target.value !== '' && event.target.value !== window.promptBasicAutoName;
};
