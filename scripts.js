$(document).ready(function () {
    loadReviews();

    $('#feedbackForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'submit_review.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    loadReviews();
                    $('#feedbackForm')[0].reset();
                } else {
                    alert(result.message);
                }
            }
        });
    });

    function loadReviews() {
        $.ajax({
            url: 'load_reviews.php',
            method: 'GET',
            success: function (data) {
                $('#reviews').html(data);
            }
        });
    }
});
