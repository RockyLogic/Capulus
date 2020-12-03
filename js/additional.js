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
 * Helper method to get a cookie
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
 */
function addItem(itemId){
  temp = getCookie(itemId)
  if (temp != ""){
    setCookie(itemId, parseInt(temp) + 1, 30)
  }
  else{
    setCookie(itemId, 1, 30)
  }
}

/**
 * Redirects to the item description page
 * @param {int}  id Item id
 */
function viewItem(id)
{
  window.location.href = "itemDisplay.html?id=" + id;
}

function deleteInfo(){
  deleteCache();
  deleteCookies();
}


function deleteCache(){
  window.sessionStorage.clear();
}

function deleteCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Mon, 01 Jan 1900 00:00:00 GMT";
    }
}

if (window.location.pathname=='/orderReview') {
}
