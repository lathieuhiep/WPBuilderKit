(function ($) {
    "use strict";

    const $tableBody = $('table.wp-list-table tbody');
    if (!$tableBody.length) return;

    let lastSubmittedColor = null;
    let lastSubmittedImage = null;

    // Handle image picker
    $(document).on('click', '.efa-upload-image', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const $container = $btn.closest('.form-field, td');
        const $input = $container.find('input[type="hidden"]');
        const $preview = $container.find('.efa-image-preview');

        let frame = wp.media({
            multiple: false
        });

        frame.on('select', function () {
            const attachment = frame.state().get('selection').first().toJSON();
            const imageId = attachment.id;
            const imageURL = attachment.sizes?.thumbnail?.url || attachment.url;

            $input.val(imageId);
            $preview.html(`<img src="${imageURL}" style="max-width:80px;"  alt=""/>`);

            lastSubmittedImage = {
                id: imageId,
                url: imageURL
            };
        });

        frame.open();
    });

    // Track AJAX add-tag requests to capture color/image
    $(document).ajaxSend(function (event, xhr, settings) {
        if (!settings.data || !settings.data.includes('action=add-tag')) return;

        const params = new URLSearchParams(settings.data);
        const taxonomy = params.get('taxonomy');
        const color = params.get('term_color');
        const imageId = params.get('term_image');

        if (taxonomy?.startsWith('pa_')) {
            lastSubmittedColor = color || null;
            lastSubmittedImage = imageId && lastSubmittedImage?.id === imageId ? lastSubmittedImage : null;
        }
    });

    // Observe DOM for new rows
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                if (node.nodeName !== 'TR' || !node.id.startsWith('tag-')) return;

                const $row = $(node);
                const taxonomy = $('#addtag input[name="taxonomy"]').val();
                if (!taxonomy?.startsWith('pa_')) return;

                insertColorCell($row);
                insertImageCell($row);
            });
        });
    });

    observer.observe($tableBody[0], { childList: true });

    // Insert color cell
    function insertColorCell($row) {
        if (!lastSubmittedColor) return;

        waitForInsert($row, 'color', function ($cell) {
            const html = `
                <div style="display:flex;align-items:center;gap:6px">
                    <div style="width:24px;height:24px;border:1px solid #ccc;background:${lastSubmittedColor};"></div>
                    <span style="font-family:monospace;">${lastSubmittedColor}</span>
                </div>
            `;
            $cell.html(html);
            lastSubmittedColor = null;
        });
    }

    // Insert image cell
    function insertImageCell($row) {
        if (!lastSubmittedImage?.url) return;

        waitForInsert($row, 'image', function ($cell) {
            $cell.html(`<img src="${lastSubmittedImage.url}" style="width:50px;height:auto;" alt=""/>`);
            lastSubmittedImage = null;
        });
    }

    // Wait for .column-posts and insert before it
    function waitForInsert($row, type, callback) {
        const maxAttempts = 20;
        let attempts = 0;

        const interval = setInterval(function () {
            const $handleCell = $row.find('td.column-posts');
            if ($handleCell.length) {
                clearInterval(interval);

                const colClass = `column-${type}`;
                if (!$row.find(`td.${colClass}`).length) {
                    $(`<td class="${colClass}"></td>`).insertBefore($handleCell);
                }

                callback($row.find(`td.${colClass}`));
            }

            if (++attempts > maxAttempts) {
                clearInterval(interval);
            }
        }, 100);
    }

    // Handle delete swatch meta after term is deleted via AJAX
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (!settings.data || !settings.data.includes('action=delete-tag')) return;

        const taxonomy = new URLSearchParams(window.location.search).get('taxonomy');
        if (!taxonomy || !taxonomy.startsWith('pa_')) return;

        const match = settings.data.match(/tag_ID=(\d+)/);
        const termId = match ? parseInt(match[1], 10) : null;
        if (!termId) return;

        $.post(ajaxurl, {
            action: 'efa_delete_term_meta_by_term_id',
            term_id: termId,
            taxonomy: taxonomy
        }, function (res) {
            if (res.success) {
                console.log('Metadata deleted successfully');
            } else {
                console.warn('Error deleting metadata:', res.data?.msg || 'Unknown');
            }
        });
    });

})(jQuery);