(function ($) {

    function bindEvents() {
        $(".yandex-update").click(function (e) {
            $.ajax({
                url: "/generator/general/start-update"
            });
        });
    }

    bindEvents();

}(jQuery));