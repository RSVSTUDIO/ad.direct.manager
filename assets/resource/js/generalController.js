(function ($) {

    function bindEvents() {
        $(".yandex-update").click(function (e) {
            var brandIds = [];

            $("[name*=brandsList]:checked").each(function () {
                brandIds.push($(this).val());
            });

            $.ajax({
                url: "/generator/general/start-update",
                method: "POST",
                data: {
                    shopId: $(this).data('shopId'),
                    priceFrom: $("[name*=price_from]").val(),
                    priceTo: $("[name*=price_to]").val(),
                    brandIds: brandIds
                },
                success: function (result) {
                    alert(result.message);
                }
            });
        });
    }

    bindEvents();

}(jQuery));