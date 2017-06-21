"use strict";
(function() {
    function init() {
        // Mark recorc as "pranishem" or not
        var $toggleCheckbox = $('[type=checkbox].toggle-checkbox');
        $toggleCheckbox.on('change', function(e) {
            var $_elem = $(e.target);
            var checkedFlag = $_elem.prop('checked');
            var _elemId = $_elem.attr('data-id');
            if(confirm('Are you sure you want to change state of this record?')) {
                $.ajax({
                    method: "POST",
                    url: "/record/update-state",
                    data: {
                        id: _elemId
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
                        console.error(JSON.parse(jqXHR));
                    }
                })
            } else {
                $_elem.prop('checked', !checkedFlag);
            }
        });
        // Clear filters previous data
        var $resetButton = $('button.clear-button');
        var $filterInputsElement = $('div.record-search input[type=text].form-control');
        $resetButton.on('click', function(e) {
            $filterInputsElement.each(function(i, e) {
                $(e).val("");
            });
        });
    }
    $(document).ready(function(e) {
        init();
    })
})()