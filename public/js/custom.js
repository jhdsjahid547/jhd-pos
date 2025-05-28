$(document).ready(function() {
    //tooltip
    $('[data-bs-toggle="tooltip"]').tooltip();
    // for search component auto submit form
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }

    // Auto-submit handler
    $('.search-input').on('input', debounce(function() {
        const input = $(this);
        const column = input.data('column');
        const form = input.closest('form');
        if (input.data('last-value') !== input.val()) {
            input.data('last-value', input.val());
            form.find('input[name="page"]').remove();
            form.submit();
        }
    }, 1000));
});
