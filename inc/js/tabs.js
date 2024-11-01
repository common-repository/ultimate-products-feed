upf_tabControl();

/*
We also apply the switch when a viewport change is detected on the fly
(e.g. when you resize the browser window or flip your device from 
portrait mode to landscape). We set a timer with a small delay to run 
it only once when the resizing ends. It's not perfect, but it's better
than have it running constantly during the action of resizing.
*/
var resizeTimer;
jQuery(window).on("resize", function(e) {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
    upf_tabControl();
  }, 250);
});

/*
The function below is responsible for switching the tabs when clicked.
It switches both the tabs and the accordion buttons even if 
only the one or the other can be visible on a screen. We prefer
that in order to have a consistent selection in case the viewport
changes (e.g. when you esize the browser window or flip your 
device from portrait mode to landscape).
*/
function upf_tabControl() {
  var tabs = jQuery(".tabbed-content").find(".tabs");
  if (tabs.is(":visible")) {
    tabs.find("a").on("click", function(event) {
      event.preventDefault();
      var target = jQuery(this).attr("href"),
          tabs = jQuery(this).parents(".tabs"),
          buttons = tabs.find("a"),
          item = tabs.parents(".tabbed-content").find(".item");
      buttons.removeClass("active");
      item.removeClass("active");
      jQuery(this).addClass("active");
      jQuery(target).addClass("active");
    });
  } else {
    jQuery(".item").on("click", function() {
      var container = jQuery(this).parents(".tabbed-content"),
          currId = jQuery(this).attr("id"),
          items = container.find(".item");
      container.find(".tabs a").removeClass("active");
      items.removeClass("active");
      jQuery(this).addClass("active");
      container.find('.tabs a[hrefjQuery="#' + currId + '"]').addClass("active");
    });
  }
}
