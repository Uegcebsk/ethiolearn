<?php
include_once("Header.php");
include_once("../DB_Files/db.php");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="col-sm-9 mt-5">
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Quiz Category">
    </div>
    <div id="result"></div>
</div>

<script>
    $(document).ready(function(){
        // Fetch all results when the page loads
        fetchResults("");

        $('#search_text').keyup(function(){
            var txt=$(this).val();
            // Filter results based on search text
            filterResults(txt);
        });

        function fetchResults(searchText) {
            $.ajax({
                url: "result_fetch.php",
                type: "post",
                data: { search: searchText },
                dataType: "text",
                success: function (data) {
                    $('#result').html(data);
                }
            });
        }

        function filterResults(searchText) {
            $('#result .quiz-category').each(function() {
                var category = $(this).text().toLowerCase();
                if(category.indexOf(searchText.toLowerCase()) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }
    });
</script>

<?php
include_once("Footer.php");
?>
