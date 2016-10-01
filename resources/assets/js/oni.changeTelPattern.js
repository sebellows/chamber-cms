(function () {
  "use strict";

  var getTitleValue = function(x) {
    return x.getAttribute('title');
  }

  var createArrow = function() {
    let arrow =document.createElement('span');
    arrow.style.cssText = 'border-bottom:6px solid rgba(0,0,0,0.8);border-left:6px solid transparent;border-right:6px solid transparent;display:block;position:absolute;top:-6px;left:50%;-webkit-transform:translateX(-50%);translateX(-50%);';

    return arrow;
  }

  /**
   * Generate the markup for a tooltip instance
   * 
   * @param  {obj} x  the element that will generate the tooltip when clicked
   * @return {obj}   the appended tooltip
   */
  var createTooltip = function(x) {
    let tooltipDiv = document.createElement('div');
    let tooltipContent = getTitleValue(x);
    let tooltipArrow = createArrow();

    tooltipDiv.classList.add('chamber-tooltip');
    tooltipDiv.innerHTML = tooltipContent;
    tooltipDiv.style.cssText = 'background:rgba(0,0,0,0.8);border-radius:4px;color:#fff;font:13px/1.3 sans-serif;text-align:center;padding:5px;width:200px;position:absolute;top:100%;left:-95px;z-index:1000;';
    tooltipDiv.appendChild(tooltipArrow);

    x.appendChild(tooltipDiv);
  }

  /**
   * Remove the tooltip
   * 
   * @return void
   */
  var removeTooltip = function() {
    let tooltipParent = document.querySelector('.chamber-tooltip').parentNode;
    tooltipParent.removeChild(tooltipParent.childNodes[0]);
  }

  /**
   * Toggle a tooltip
   * 
   * @param  {obj} x  the element that will generate the tooltip when clicked
   * @return mixed
   */
  var toggleTooltip = function(x) {
    if ( x.hasChildNodes() ) {
      x.removeChild(x.childNodes[0]);
    }
    else {
      createTooltip(x);
    }
  }

  // Event Listeners
  document.addEventListener('click', function(event) {
    if (event.target.hasAttribute('data-chamber-toggle')) {
      toggleTooltip(event.target);
    }
  }, false);

  // Click anywhere to dismiss the tooltip
  // document.querySelector('html').addEventListener('click', function(event) {
  //   if ( document.querySelector('.chamber-tooltip') ) {
  //     removeTooltip();
  //   }
  // }, false);

})();