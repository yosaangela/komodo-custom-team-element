(function($) {
    var clickHandler = function($scope, $) {
        console.log("loaded");

        $(".kcte-widget-button").click(function() {
            console.log("clicked");
            var $button = $(this);
            var $rootWidget = $button.closest(".kcte-widget");
            var $popup = $rootWidget.find(".kcte-widget-popup");

            $popup.addClass("is-open");
        });

        $(".kcte-widget-popup-close").click(function() {
            var $closeButton = $(this);
            var $popup = $closeButton.closest(".kcte-widget-popup");

            $popup.removeClass("is-open");
        });

        $(document).on("keyup", function(e) {
            if (e.key === "Escape") {
                console.log("closing with Escape");
                $(".kcte-widget-popup.is-open").each(function() {
                    $(this).removeClass("is-open");
                });
            }
        });
    };

    $(window).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/kcte_widget.default",
            clickHandler,
        );
    });
})(jQuery);
