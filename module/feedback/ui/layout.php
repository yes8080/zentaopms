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
.feedback-fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
}
.feedback-detail {
    max-width: 75rem;
    margin-inline: auto;
}
.feedback-detail-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
}
.feedback-detail-header h2 {
    min-width: 0;
    overflow-wrap: anywhere;
}
.feedback-detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(16rem, 24rem);
    gap: 1rem;
    margin-top: 1rem;
}
.feedback-detail-main, .feedback-detail-meta {
    display: grid;
    align-content: start;
    gap: 1rem;
    min-width: 0;
}
.feedback-card {
    padding: 1rem 1.25rem;
    overflow-wrap: anywhere;
}
.feedback-card h3 {
    margin: 0 0 0.75rem;
    font-size: 1rem;
    font-weight: 600;
}
.feedback-summary {
    margin: 0;
}
.feedback-summary > div {
    display: grid;
    grid-template-columns: minmax(5rem, 1fr) minmax(0, 2fr);
    gap: 0.75rem;
    padding-block: 0.4rem;
}
.feedback-summary dt {
    font-weight: normal;
    color: var(--color-gray-600, #526079);
}
.feedback-summary dd {
    margin: 0;
}
.feedback-saved {
    margin-top: 0.75rem;
    color: var(--color-success-700, #167454);
}
.feedback-float-toolbar {
    position: sticky;
    bottom: 0;
    z-index: 2;
    display: flex;
    justify-content: safe center;
    margin-top: 1rem;
    overflow-x: auto;
}
.feedback-float-toolbar > .float-toolbar {
    flex: 0 0 auto;
    flex-wrap: nowrap;
}
.feedback-upload input {
    max-width: 100%;
}
@media (max-width: 900px) {
    .feedback-detail-grid {
        grid-template-columns: minmax(0, 1fr);
    }
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
.feedback-description {
    white-space: pre-line;
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
.feedback-operation:not(:has(select[name="closedReason"] option[value="repeat"]:checked)) .feedback-repeat-field {
    display: none;
}
.feedback-operation > button {
    justify-self: start;
}
.feedback-browse-heading {
    justify-content: space-between;
}
.feedback-search {
    display: grid;
    grid-template-columns: minmax(0, 1.3fr) repeat(2, minmax(0, 1fr)) auto;
    align-items: center;
    gap: 0.5rem;
    margin-block: 1rem;
}
.feedback-search > .form-control {
    min-width: 0;
    width: 100%;
}
.feedback-table {
    overflow-x: auto;
}
.feedback-table > .table {
    min-width: 42rem;
}
@media (max-width: 640px) {
    .feedback-search {
        grid-template-columns: minmax(0, 1fr);
    }
    .feedback-fields {
        grid-template-columns: minmax(0, 1fr);
    }
}
CSS);
