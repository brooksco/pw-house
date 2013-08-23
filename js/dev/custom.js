// @codekit-prepend "jquery-1.10.2.js"
// @codekit-prepend "enquire.js"
// @codekit-prepend "waypoints.js"
// @codekit-prepend "../../css/royalslider/jquery.royalslider.min.js"

// Once the page has loaded...
$(document).ready(function() {

  $('#full-width-slider').royalSlider({
    arrowsNav: true,
    loop: true,
    keyboardNavEnabled: true,
    controlsInside: false,
    imageScaleMode: 'fill',
    arrowsNavAutoHide: false,
    // autoScaleSlider: true, 
    // autoScaleSliderWidth: 960,     
    // autoScaleSliderHeight: 350,
    controlNavigation: 'bullets',
    thumbsFitInViewport: false,
    navigateByClick: true,
    startSlideId: 0,
    autoPlay: true,
    transitionType:'move',
    globalCaption: false,
    deeplinking: {
      enabled: true,
      change: false
    },
    /* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
    // imgWidth: 1400,
    // imgHeight: 680
  });

}); // End ready