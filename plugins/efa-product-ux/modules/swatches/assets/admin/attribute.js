(function ($) {
    "use strict";

    const attributesTable = $('.attributes-table');

    $(document).ready(function () {
        if ( attributesTable.length ) {
            let textColumn = '';
            let textRow = '';

            if (typeof efaAttrVars !== 'undefined' && efaAttrVars.text_column && efaAttrVars.text_row) {
                textColumn = efaAttrVars.text_column;
                textRow = efaAttrVars.text_row;
            }

            attributesTable.find('tr th').eq(1).after(`<th>${textColumn}</th>`);

            attributesTable.find('tbody tr').each(function () {
                $(this).find('td').eq(1).after(`<td class="attr-type">${textRow}</td>`);
            });
        }
    });

    $(window).on('load', function () {
        $.ajax({
            url: efaAttrVars.ajax_url,
            type: 'POST',
            data: {
                action: 'efa_get_attribute_types',
                security: efaAttrVars.nonce
            },
            success: function (response) {
                if (response.success && response.data.attributeList && response.data.attributeList.length > 0) {
                    const dataAttrList = response.data.attributeList;

                    dataAttrList.forEach(function (item, index) {
                        const row = attributesTable.find('tbody tr').eq(index);

                        if ( row.length ) {
                            const displayType = item.display_type || '-';
                            row.find('td').eq(2).text(displayType);
                        }
                    })
                } else {
                    attributesTable.find('tbody tr').each(function () {
                        $(this).find('td').eq(1).after(`<td class="attr-type">-</td>`);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching attribute types:', error);
            }
        })
    })
})(jQuery);