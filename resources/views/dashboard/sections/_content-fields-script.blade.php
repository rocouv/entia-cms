<script>
    document.querySelectorAll('[data-section-type]').forEach((typeSelect) => {
        const syncFields = () => {
            document.querySelectorAll('[data-section-fields]').forEach((fieldset) => {
                const isActive = fieldset.dataset.sectionFields === typeSelect.value;

                fieldset.hidden = !isActive;
                fieldset.disabled = !isActive;
            });
        };

        typeSelect.addEventListener('change', syncFields);
        syncFields();
    });
</script>
