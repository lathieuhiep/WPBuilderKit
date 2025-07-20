/*
* Helper functions
* */

// Function to bind two date inputs so that the 'from' date cannot be after the 'to' date and vice versa
const bindDateRange = (fromSelector, toSelector) => {
    const fromInput = typeof fromSelector === 'string' ? document.querySelector(fromSelector) : fromSelector;
    const toInput = typeof toSelector === 'string' ? document.querySelector(toSelector) : toSelector;

    if (!fromInput || !toInput) return;

    // set initial min and max values based on existing input values
    if (fromInput.value) {
        toInput.min = fromInput.value;
    }
    if (toInput.value) {
        fromInput.max = toInput.value;
    }

    // listen for changes in the from and to inputs
    fromInput.addEventListener('change', () => {
        toInput.min = fromInput.value || '';
    });

    toInput.addEventListener('change', () => {
        fromInput.max = toInput.value || '';
    });
}

// Function to automatically open the date picker when the input is focused
const autoOpenDatePicker = (selector) => {
    const input = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!input) return;

    input.addEventListener('mousedown', (e) => {
        e.preventDefault();
        input.focus();
        if (typeof input.showPicker === 'function') {
            input.showPicker();
        }
    });
}

/*
* call function
* */

document.addEventListener('DOMContentLoaded', function () {
    // call bindDateRange on page load for the default date range inputs
    bindDateRange('#filter_created_from', '#filter_created_to');

    // call autoOpenDatePicker on page load for the default date range inputs
    autoOpenDatePicker('#filter_created_from');
    autoOpenDatePicker('#filter_created_to');
});