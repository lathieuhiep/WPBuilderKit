(function ($) {
    "use strict";

    const columnLabel = 'Hiển thị';

    function renderDisplayTypeColumn(data) {
        const items = Array.isArray(data.items) ? data.items : [];

        const $table = $('table.attributes-table');
        if (!$table.length || !items.length) return;

        const $theadRow = $table.find('thead tr');
        const $tbodyRows = $table.find('tbody tr');

        // Thêm tiêu đề nếu chưa có
        if ($theadRow.find('th').filter((_, th) => $(th).text().trim() === columnLabel).length === 0) {
            $theadRow.find('th').eq(1).after(`<th>${columnLabel}</th>`);
        }

        // Thêm từng dòng
        $tbodyRows.each(function (i) {
            const rowData = items[i] || {};
            const $row = $(this);
            if (!$row.find('td').length || $row.find('td.efa-display-type').length) return;

            $row.find('td').eq(1).after(`<td class="efa-display-type">${rowData.display_type || '—'}</td>`);
        });
    }

    function fetchAndRender() {
        $.post(ajaxurl, { action: 'efa_get_attribute_display_types' }, function (res) {
            if (res.success && res.data) {
                renderDisplayTypeColumn(res.data);
            }
        });
    }

    function fastDetectAndRender() {
        // Ưu tiên dò nhanh bảng bằng polling
        let checkCount = 0;
        const maxTries = 10;

        const fastCheck = setInterval(() => {
            const $table = $('table.attributes-table');
            if ($table.length) {
                clearInterval(fastCheck);
                fetchAndRender();
            } else if (++checkCount >= maxTries) {
                clearInterval(fastCheck);
                fallbackObserve(); // nếu quá 10 lần mà chưa thấy thì dùng observer
            }
        }, 50); // mỗi 50ms dò 1 lần
    }

    function fallbackObserve() {
        const observer = new MutationObserver(() => {
            const $table = $('table.attributes-table');
            if ($table.length) {
                observer.disconnect();
                fetchAndRender();
            }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }

    $(document).ready(fastDetectAndRender);
})(jQuery);