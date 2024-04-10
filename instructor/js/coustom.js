$(document).ready(function($){
    $('#itemsPerPage').change(function(){
        var itemsPerPage = $(this).val();
        var currentQuery = window.location.search;
        var newQuery = updateQueryStringParameter(currentQuery, 'itemsPerPage', itemsPerPage);
        window.location.search = newQuery;
    });

    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    var debounceTimer;
    $('#search_text').keyup(function(){
        clearTimeout(debounceTimer);
        var txt = $(this).val();
        debounceTimer = setTimeout(function() {
            if (txt != '') {
                $.ajax({
                    url: "search_materials.php", // Adjust the URL to your search script
                    type: "post",
                    data: {search_text: txt},
                    dataType: "html",
                    success: function (data) {
                        $('.material-list').html(data);
                    }
                });
            } else {
                // Reload the page without search parameters
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>";
            }
        }, 500); // Adjust the delay as needed
    });
});
