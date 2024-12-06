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

    function addUrlDisplay($idField) {
        if ($idField.closest('.acf-input').find('.faq-url-display').length === 0) {
            const $wrapper = $('<div class="acf-input-wrap"></div>');
            const $urlDisplay = $('<div class="faq-url-display" style="margin-top: 5px; font-size: 12px; color: #666;"></div>');

            $idField.wrap($wrapper);
            $idField.after($urlDisplay);
            updateUrlDisplay($idField);

            $idField.on('input', function() {
                updateUrlDisplay($(this));
            });
        }
    }

    function updateUrlDisplay($idField) {
        const id = $idField.val();
        const permalink = getPermalink();
        const $display = $idField.closest('.acf-input-wrap').find('.faq-url-display');

        if (id && permalink) {
            const fullUrl = `${permalink}#${id}`;
            $display.html(`
                <div style="display: flex; align-items: center; gap: 6px;">
                    <code style="flex: 1;">${fullUrl}</code>
                    <span class="copy-url dashicons dashicons-clipboard"
                          style="cursor: pointer; color: #787c82;"
                          title="Copy URL to clipboard"></span>
                </div>
            `);

            $display.find('.copy-url').on('click', function() {
                navigator.clipboard.writeText(fullUrl).then(() => {
                    const $icon = $(this);
                    $icon.removeClass('dashicons-clipboard').addClass('dashicons-yes');
                    setTimeout(() => {
                        $icon.removeClass('dashicons-yes').addClass('dashicons-clipboard');
                    }, 1000);
                });
            });
        } else {
            $display.empty();
        }
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

                addUrlDisplay($idField);
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
                    updateUrlDisplay($idField);
                }
            }
        );

        // Handle new rows
        acf.addAction('append_field/name=faq_sections', function(field) {
            field.$el.find('.acf-field-text[data-name="id"] input').each(function() {
                addUrlDisplay($(this));
            });
        });
    }

    // Initialize when ACF is ready
    acf.addAction('ready', initIdGenerator);

})(jQuery);