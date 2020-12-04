/**
 * Helper method to set a cookie
 * @param {string}  name Cookie name
 * @param {string}  value Cookie value
 * @param {Number}  days Number of days cookie is stored
 */
function setCookie(name, value, days) {
  var d = new Date();
  d.setTime(d.getTime() + (days*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

/**
 * Helper method to get a cookie by cookie name
 * @param {string}  cookieName Cookie name
 */
function getCookie(cookieName) {
  var name = cookieName + "=";
  var cookieArr = document.cookie.split(';');

  for(var i = 0; i < cookieArr.length; i++) {
    var element = cookieArr[i];
    while (element.charAt(0) == ' ') {
      element = element.substring(1);
    }
    if (element.indexOf(name) == 0) {
      return element.substring(name.length, element.length);
    }
  }
  return "";
}

/**
 * Adds products to cookies
 * @param {int}  itemId Item id
 * @param {int}  inv Item inv
 */
function addItem(itemId, inv){
  temp = getCookie(itemId)
  if (temp == ""){
    setCookie(itemId, 1, 30);

  }
  else if(temp != inv){
    setCookie(itemId, parseInt(temp) + 1, 30);
  }
}

/**
 * Redirects to the item description page
 * @param {int}  id Item id
 */
function viewItem(id){
  window.location.href = "itemDisplay.html?id=" + id;
}

/**
 * Remove products from cart
 * @param {int}  id Item id
 */
function removeFromCart(id){
  temp = getCookie(id)

  //if cookie set
  if (temp != ""){
    setCookie(id, parseInt(temp) - 1, 30)
    document.location.reload(true);
  }
}

/**
 * Add products to cart + refreshes page
 * @param {int}  id Item id
 *  @param {int}  inv Item inv
 */
function addToCart(id, inv){
  if (inv != 0){
    addItem(id, inv);
    document.location.reload(true);
  }
}
