$(document).ready(function () {
    /**
     * Удаление элемента из GridView
     */
    $(document).on('click', '#deleteItem', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');

        swal({
            title: "Вы уверены?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post(url, [], function (data) {
                    if (data.result === true) {
                        swal("Good job!", "You clicked the button!", "success")
                            .then(() => {
                                location.reload();
                            });
                    }
                });
            }
        });
    });
});
