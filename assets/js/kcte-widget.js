/**
 * GLobal Escape key handler, to remove all popup that is opening
 * This is not depend on Elementor
 */
jQuery(document).on("keyup", function(e) {
    if (e.key === "Escape") {
        console.log("closing with Escape");
        jQuery(".kcte-widget-popup.is-open").each(function() {
            jQuery(this).removeClass("is-open");
        });
    }
});

/**
 * This one absolutely depends with Elementor
 */
class KcteHandlerClass extends elementorModules.frontend.handlers.Base {
    // ------------------------------------------------------------------------
    // ELementors Required Function
    // ------------------------------------------------------------------------

    getDefaultSettings() {
        return {
            selectors: {
                button: ".kcte-widget-button",
                popup: ".kcte-widget-popup",
                popupCloseButton: ".kcte-widget-popup-close",
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings("selectors");
        return {
            $button: this.$element.find(selectors.button),
            $popup: this.$element.find(selectors.popup),
            $popupCloseButton: this.$element.find(selectors.popupCloseButton),
        };
    }

    bindEvents() {
        this.elements.$button.on("click", this.openPopup.bind(this));
        this.elements.$popupCloseButton.on("click", this.closePopup.bind(this));
    }

    // ------------------------------------------------------------------------
    // All of my functions
    // ------------------------------------------------------------------------

    openPopup() {
        console.log("opening ... ");
        this.elements.$popup.addClass("is-open");
    }

    closePopup() {
        console.log("closing ... ");
        this.elements.$popup.removeClass("is-open");
    }
}

jQuery(window).on("elementor/frontend/init", function() {
    const addHandler = function($element) {
        elementorFrontend.elementsHandler.addHandler(KcteHandlerClass, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction(
        "frontend/element_ready/kcte_widget.default",
        addHandler,
    );
});
