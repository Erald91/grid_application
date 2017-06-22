"use strict";
(function() {
    function confirmModal() {
        var $confirmModal = $('#confirmModal');
        var $closeButton = $confirmModal.find('button#closeModal');
        var $proceedButton = $confirmModal.find('button#proceedModal');

        $confirmModal.modal('show');

        return new Promise(function(resolve, reject) {
            $closeButton.on('click', function(e) {
                $confirmModal.modal('hide');
                reject({resolved: false});
            });
            $proceedButton.on('click', function(e) {
                $closeButton.prop('disabled', true);
                $proceedButton.prop('disabled', true);
                resolve({resolved: true})
            });
        });
    }

    function init() {
        // Manage Record state
        var $toggleCheckbox = $('[type=checkbox].toggle-checkbox');
        $toggleCheckbox.on('change', function(e) {
            var $_elem = $(e.target);
            var checkedFlag = $_elem.prop('checked');
            var _recordState = $_elem.attr('data-state');
            var _elemId = $_elem.attr('data-id');

            confirmModal()
            .then(function({resolved}) {
                $.ajax({
                    method: "POST",
                    url: "/record/update-state",
                    data: {
                        id: _elemId,
                        state: _recordState
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if(response.success) location.reload();
                        else {
                            console.error(response);
                            alert('Something went wrong!');
                        }
                    },
                    error: function(jqXHR) {
                        jqXHR = JSON.parse(jqXHR);
                        alert(jqXHR.responseText);
                        console.error(jqXHR);
                    }
                })
            }, function({resolved}) {
                 $_elem.prop('checked', !checkedFlag);
            })
        });

        // Clear filters from previous data
        var $resetButton = $('button.clear-button');
        var $filterInputsElement = $('div.record-search input[type=text].form-control');
        $resetButton.on('click', function(e) {
            $filterInputsElement.each(function(i, e) {
                $(e).val("");
            });
        });

        // Mark as disabled all checked checkBoxes if user not admin
        var $checkedCheckboxes = $('input[type=checkbox].toggle-checkbox:checked');
        if(!parseInt(window.isAdmin)) $checkedCheckboxes.prop('disabled', true);
    }
    $(document).ready(function(e) {
        init();
    })
})()