"use strict";

(function ($) {
	"use strict";

	function codesignerGetTranslated(key, args) {
		const translations = {
			promotionDialogHeader: "Unlock {0}",
			promotionDialogMessage:
				"Upgrade to the Pro version of {0} to access exclusive features and enhance your site.",
		};
		let translation = translations[key] || key;
		if (args) {
			args.forEach((arg, index) => {
				translation = translation.replace(`{${index}}`, arg);
			});
		}

		return translation;
	}

	/**
	 * Add pro widgets placeholder
	 */
	elementor.hooks.addFilter(
		"panel/elements/regionViews",
		function (regionViews) {
			if (_.isEmpty(CODESIGNER.promotional_widgets)) {
				return regionViews;
			}

			var elementsView = regionViews.elements.view,
				categoriesView = regionViews.categories.view,
				elementsCollection = regionViews.elements.options.collection,
				categoriesCollection =
					regionViews.categories.options.collection;

			var proWidgets = [];
			var CATEGORY_NAME = "codesigner-shop";

			// Add promotional widgets to elements collection
			_.each(CODESIGNER.promotional_widgets, function (widget, name) {
				var category = widget.category;

				elementsCollection.add({
					name: "codesigner-" + name,
					title: widget.title,
					icon: widget.icon,
					categories: [category],
					editable: false,
				});

				// Add widget to the proWidgets list
				elementsCollection.each(function (element) {
					if (element.get("categories").includes(category)) {
						proWidgets.push(element);
					}
				});
			});

			// Update categories with pro widgets
			_.each(proWidgets, function (widget) {
				var widgetCategory = widget.get("categories")[0];
				var categoryIndex = categoriesCollection.findIndex(function (
					category
				) {
					return category.get("name") === widgetCategory;
				});

				if (categoryIndex >= 0) {
					var category = categoriesCollection.at(categoryIndex);
					category.set({
						items: proWidgets.filter((w) =>
							w.get("categories").includes(widgetCategory)
						),
					});
				}
			});
			var OriginalElementView = elementsView.prototype.childView;

			// Extend ElementView to show promotional dialog
			var ElementView = {
				className: function () {
					var className =
						OriginalElementView.prototype.className.call(this);
					if (!this.isEditable() && this.isCodesignerWidget()) {
						className += " codesigner-element--promotion";
					}
					return className;
				},
				isCodesignerWidget: function () {
					var widgetName = this.model.get("name");
					return (
						widgetName != undefined &&
						widgetName.indexOf("codesigner-") === 0
					);
				},
				onMouseDown: function () {
					if (this.isCodesignerWidget()) {
						elementor.promotion.showDialog({
							title: codesignerGetTranslated(
								"promotionDialogHeader",
								[this.model.get("title")]
							),
							content: codesignerGetTranslated(
								"promotionDialogMessage",
								[this.model.get("title")]
							),
							targetElement: this.el,
							position: {
								blockStart: "-7",
							},
							actionButton: {
								url: "https://codexpert.io/codesigner/pricing?utm_source=live+editor&utm_medium=in-plugin&utm_campaign=widgets",
								text: "Get CoDesigner Pro",
								classes: [
									"elementor-button",
									"codesigner-btn--promotion",
									"go-pro",
								],
							},
						});
					} else {
						// Default behavior for Elementor's widgets, show Elementor dialog
						OriginalElementView.prototype.onMouseDown.call(this);
					}
				},
			};

			// Extend elementsView and categoriesView
			regionViews.elements.view = elementsView.extend({
				childView: elementsView.prototype.childView.extend(ElementView),
			});
			regionViews.categories.view = categoriesView.extend({
				childView: categoriesView.prototype.childView.extend({
					childView:
						categoriesView.prototype.childView.prototype.childView.extend(
							ElementView
						),
				}),
			});

			return regionViews;
		}
	);
})(jQuery);
