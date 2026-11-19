<?php
namespace zin;

context::css(<<<'CSS'
.feedback-editor {
    width: 100%;
    max-width: 56rem;
    margin-inline: auto;
}
.feedback-form,
.feedback-operation {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 1rem;
}
.feedback-fields,
.feedback-summary {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}
.feedback-summary {
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 12rem), 1fr));
}
.feedback-field {
    display: grid;
    gap: 0.375rem;
    min-width: 0;
}
.feedback-field > .form-control {
    width: 100%;
    min-width: 0;
}
.feedback-field > textarea {
    resize: vertical;
}
.feedback-options,
.feedback-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
}
.feedback-operation {
    margin-top: 0.5rem;
    gap: 0.5rem;
}
.feedback-operation > button {
    justify-self: start;
}
@media (max-width: 640px) {
    .feedback-fields {
        grid-template-columns: minmax(0, 1fr);
    }
}
CSS);
