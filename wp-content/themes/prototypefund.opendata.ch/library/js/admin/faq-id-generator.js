(function($) {
    function generateValidId(text) {
        const slug = new URLSearchParams(`q=${text}`).get('q')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');

        return slug;
    }

    function getPermalink() {
        return window.faqSettings ? faqSettings.permalink : '';
    }

    function initIdGenerator() {
        // Handle existing rows on page load
        $('.acf-field-repeater[data-name="faq_sections"]').each(function() {
            $(this).find('.acf-field-text[data-name="headline"] input').each(function() {
                const $headlineInput = $(this);
                const $idField = $headlineInput
                    .closest('.acf-row')
                    .find('.acf-field-text[data-name="id"] input');

                if (!$idField.val() && $headlineInput.val()) {
                    const generatedId = generateValidId($headlineInput.val());
                    $idField.val(generatedId);
                }

            });
        });

        // Handle changes to headline fields
        $('.acf-field-repeater[data-name="faq_sections"]').on('change',
            '.acf-field-text[data-name="headline"] input',
            function() {
                const $row = $(this).closest('.acf-row');
                const $idField = $row.find('.acf-field-text[data-name="id"] input');
                const $headlineInput = $row.find('.acf-field-text[data-name="headline"] input');

                if (!$idField.val() && $headlineInput.val()) {
                    const generatedId = generateValidId($headlineInput.val());
                    $idField.val(generatedId);
                }
            }
        );
    }

    // Initialize when ACF is ready
    acf.addAction('ready', initIdGenerator);

})(jQuery);