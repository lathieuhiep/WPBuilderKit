jQuery(document).ready(function ($) {
    const $tableBody = $('table.wp-list-table tbody');
    if (!$tableBody.length) return;

    let lastSubmittedColor = null;

    // Bắt giá trị màu từ dữ liệu AJAX gửi đi
    $(document).ajaxSend(function (event, xhr, settings) {
        if (settings.data && settings.data.includes('action=add-tag')) {
            const params = new URLSearchParams(settings.data);
            const taxonomy = params.get('taxonomy');
            const color = params.get('term_color');

            if (taxonomy?.startsWith('pa_') && color) {
                lastSubmittedColor = color;
            }
        }
    });

    // Quan sát khi <tr> mới được thêm vào DOM
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                if (node.nodeName !== 'TR' || !node.id.startsWith('tag-')) return;

                const $row = $(node);
                const termId = node.id.replace('tag-', '');
                const taxonomy = $('#addtag input[name="taxonomy"]').val();
                if (!taxonomy || !taxonomy.startsWith('pa_')) return;

                waitForHandleAndInsertColorCell($row, function ($colorCell) {
                    if (lastSubmittedColor) {
                        const html = renderSwatchHTML(lastSubmittedColor);
                        $colorCell.html(html);
                        lastSubmittedColor = null;
                    }
                });
            });
        });
    });

    observer.observe($tableBody[0], { childList: true });

    // Đợi cột handle có mặt rồi chèn column-color
    function waitForHandleAndInsertColorCell($row, callback) {
        const maxAttempts = 20;
        let attempts = 0;

        const interval = setInterval(function () {
            const $handleCell = $row.find('td.column-posts');

            if ($handleCell.length) {
                clearInterval(interval);

                if (!$row.find('td.column-color').length) {
                    $('<td class="column-color"></td>').insertBefore($handleCell);
                }

                callback($row.find('td.column-color'));
            }

            if (++attempts > maxAttempts) {
                clearInterval(interval);
            }
        }, 100);
    }

    // Render HTML swatch
    function renderSwatchHTML(color) {
        return `
            <div style="display:flex;align-items:center;gap:6px">
                <div style="width:24px;height:24px;border:1px solid #ccc;background:${color};"></div>
                <span style="font-family:monospace;">${color}</span>
            </div>
        `;
    }

    jQuery(document).ajaxComplete(function (event, xhr, settings) {
        // Chỉ bắt đúng AJAX xóa term (chứa action=delete-tag)
        if (!settings.data || !settings.data.includes('action=delete-tag')) return;

        const taxonomy = new URLSearchParams(window.location.search).get('taxonomy');
        if (!taxonomy || !taxonomy.startsWith('pa_')) return;

        const match = settings.data.match(/tag_ID=(\d+)/);
        const termId = match ? parseInt(match[1], 10) : null;

        if (!termId) return;

        // Gửi yêu cầu xoá metadata sau khi term xoá xong
        jQuery.post(ajaxurl, {
            action: 'efa_delete_term_meta_by_term_id',
            term_id: termId,
            taxonomy: taxonomy
        }, function (res) {
            if (res.success) {
                console.log('Xoá thành công');
            } else {
                console.warn('Đã có lỗi:', res.data?.msg || 'Unknown');
            }
        });
    });

});
