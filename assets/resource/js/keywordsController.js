(function ($) {

    function getShopId() {
        return window.location.search.match(/shopId=(\d+)/)[1];
    }

    function bindEvents() {
        $(document).on('change', "#keywords-filter-form [name*=brandId]", function () {
            $(this).closest("form").submit();
        });

        $(document).on("click", "#keywords-filter-form [name*=onlyActive]", function () {
            $(this).closest("form").submit();
        });

        $(document).on('click', '.save-products', function (e) {
            var data = $("[name^=Products]").serialize();
            $.ajax({
                url: "/generator/keywords/save-products?shopId=" + getShopId() ,
                dataType: "json",
                data: data,
                method: "post",
                success: function (data) {
                    console.log(data);
                    alert('Данные сохранены');
                }
            });
        });
    }

    bindEvents();

}(jQuery));