let varGetUrlParameter = function varGetUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=')

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1])
        }
    }
    return false
}

jQuery(document).ready(function () {
    if (wfa_ajax.is_enfold_theme) {
        let dropdownParentEl = jQuery('.wfa-directory .wfa-directory-container .wfa-filter-form-container')
        jQuery('.wfa-select2').select2({
            dropdownParent: dropdownParentEl
            // allowClear: true,
            // placeholder: 'select'
        })
    } else {
        jQuery('.wfa-select2').select2()
    }

    jQuery('.wfa-flatpickr-date').flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d"
    })
    jQuery('.wfa-flatpickr-datetime').flatpickr({
        altInput: true,
        enableTime: true,
        altFormat: "F j, Y h:i K",
        dateFormat: "Y-m-d H:i"
    })
    if (varGetUrlParameter('directory_submit')) {
        jQuery('#wfa-filter-form-' + varGetUrlParameter('directory_submit')).trigger('submit')
    }
})

jQuery(document).on('click', '.wfa-form-clear', function () {
    let form = jQuery(this).parents('form:first')

    form.find('.wfa-select2').val(null).trigger('change')

    form.find('input[type=text], input[type=number], .flatpickr-input').attr('value', '').val('')
    form.find('input[type="checkbox"], input[type="radio"]').prop('checked', false)

    form.submit()
})

jQuery(document).on('change', '.wfa-sort-input [name=sort_by]', function () {
    let form = jQuery(this).parents('.wfa-directory-container:first').find('form:first')

    form.submit()
})

let page = 1
let currentRequest = null
jQuery(document).on('submit', '.wfa-filter-ajax-submit', function (e) {

    e.stopPropagation()
    e.preventDefault()
    let formData = new FormData(this)
    let directoryContainer = jQuery(this).parents('.wfa-directory:first')
    let sort_by = directoryContainer.find('.wfa-sort-input [name=sort_by]').val()
    page = 1

    formData.append('sort_by', sort_by)
    formData.append('page', page)

    function showLoader() {
        directoryContainer.find('.wfa-directory-loader').show()
    }

    function hideLoader() {
        directoryContainer.find('.wfa-directory-loader').hide()
    }

    function clearErrors() {
        directoryContainer.find('.wfa-directory-errors').html('')
    }

    function showErrors(errText) {
        directoryContainer.find('.wfa-directory-errors').html(
            '<div class="wfa-alert">' + errText + '</div>'
        )
    }

    function clearResults() {
        directoryContainer.find('.wfa-directory-results').html('')
    }

    function appendResults(data) {
        directoryContainer.find('.wfa-directory-results').append(data)
    }

    function updateTotalCount(count) {
        directoryContainer.find('.wfa-total-records span').html(count)
    }

    function showLoadMore() {
        directoryContainer.find('.wfa-directory-load-more-results').show()
    }

    function hideLoadMore() {
        directoryContainer.find('.wfa-directory-load-more-results').hide()
    }

    currentRequest = jQuery.ajax({
        method: 'POST',
        url: wfa_ajax.url,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function () {
            clearErrors()
            showLoader()
            clearResults()
            updateTotalCount(0)
            if (currentRequest != null) {
                currentRequest.abort();
            }
        },
        success: function (data) {
            if (typeof data.data !== 'undefined' && data.data !== '') {
                appendResults(data.data)
                updateTotalCount(data.total_count)
            } else {
                showErrors(wfa_ajax.no_results_found_text)
            }
            if (data.max_pages > data.page) {
                showLoadMore()
            } else {
                hideLoadMore()
            }
        },
        error: function (data) {
            if (data.statusText !== "abort") {
                showErrors(wfa_ajax.error_text)
            }
        },
        complete: function () {
            hideLoader()
        }
    })
})

jQuery(document).on('click', '.wfa-directory-load-more-results', function () {
    let directoryContainer = jQuery(this).parents('.wfa-directory:first')
    let form = directoryContainer.find('.wfa-filter-ajax-submit')
    let formData = new FormData(form[0])
    let sort_by = directoryContainer.find('.wfa-sort-input [name=sort_by]').val()

    formData.append('sort_by', sort_by)
    formData.append('page', page + 1)

    function showLoader() {
        directoryContainer.find('.wfa-directory-loader').show()
    }

    function hideLoader() {
        directoryContainer.find('.wfa-directory-loader').hide()
    }

    function showErrors(errText) {
        directoryContainer.find('.wfa-directory-errors').html(
            '<div class="wfa-alert">' + errText + '</div>'
        )
    }

    function appendResults(data) {
        directoryContainer.find('.wfa-directory-results').append(data)
    }

    function updateTotalCount(count) {
        directoryContainer.find('.wfa-total-records span').html(count)
    }

    function showLoadMore() {
        directoryContainer.find('.wfa-directory-load-more-results').show()
    }

    function hideLoadMore() {
        directoryContainer.find('.wfa-directory-load-more-results').hide()
    }

    jQuery.ajax({
        method: 'POST',
        url: wfa_ajax.url,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function () {
            showLoader()
            hideLoadMore()
        },
        success: function (data) {
            page = parseInt(data.page)
            if (typeof data.data !== 'undefined' && data.data !== '') {
                appendResults(data.data)
                updateTotalCount(data.total_count)
            }
            if (data.max_pages > data.page) {
                showLoadMore()
            } else {
                hideLoadMore()
            }
        },
        error: function (data) {
            showErrors(wfa_ajax.error_text)
        },
        complete: function () {
            hideLoader()
        }
    })
})